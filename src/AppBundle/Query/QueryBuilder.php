<?php

namespace AppBundle\Query;

/**
 * Transform an array of QueryClause into a Doctrine Query
 * This service is not shared
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class QueryBuilder
{

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     *
     * @var QueryMapper
     */
    private $queryMapper;

    /**
     *
     * @var \Doctrine\ORM\QueryBuilder
     */
    private $cardBuilder;

    /**
     *
     * @var \Doctrine\ORM\QueryBuilder[]
     */
    private $builders;

    /**
     *
     * @var integer
     */
    private $index;

    public function __construct (\Doctrine\ORM\EntityManager $entityManager, QueryMapper $queryMapper)
    {
        $this->entityManager = $entityManager;
        $this->queryMapper = $queryMapper;
    }

    /**
     * Take an array of QueryClause and transform them into a Doctrine ORM Query
     * 
     * @param \AppBundle\Parser\QueryClause[] $clauses
     * @param string $sortOrder
     * @return \Doctrine\ORM\Query
     */
    public function getQuery (QueryInput $input)
    {
        $this->cardBuilder = $this->entityManager->createQueryBuilder()
                ->from("AppBundle:Card", "c0")
                ->select("c0")
                ->leftJoin("c0.conjuring", "c1")
                ->addSelect("c1")
                ->leftJoin("c0.conjuredBy", "c2")
                ->addSelect("c2")
                ->leftJoin("c0.exclusiveTo", "c3")
                ->addSelect("c3")
        ;
        $this->builders = [];
        $this->index = 0;

        // process each QueryClause to add DQL to one of the QueryBuilders
        foreach ($input->getClauses() as $clause) {
            $this->processClause($clause);
        }

        // add all additional builders used during the process to the main QueryBuilder
        foreach ($this->builders as $builder) {
            $this->cardBuilder->andWhere($this->cardBuilder->expr()->exists($builder->getDQL()));
        }

        $this->addOrberBy($input->getSort());

        // return the ORM Query
        return $this->cardBuilder->getQuery();
    }

    private function getNextIndex ()
    {
        return $this->index++;
    }

    private function addOrberBy ($sort)
    {
        switch ($sort) {
            case QueryInput::SORT_NAME:
                $this->cardBuilder->orderBy("c0.name");
                break;
        }
    }

    /**
     * Process one QueryClause by adding the relevant DQL to a QueryBuilder
     * 
     * @param \AppBundle\Query\QueryClause $clause
     */
    private function processClause (QueryClause $clause)
    {
        // use the QueryMapper to have information about the clause
        $field = $this->queryMapper->getField($clause);

        // if the clause is invalid
        if ($field === FALSE) {
            return;
        }

        // will hold the DQL strings
        $predicates = [];
        // will hold the DQL parameters
        $parameters = [];
        // which method will be called to define the predicates and parameters
        $method = isset($field["method"]) ? $field["method"] : $field["type"] . "Processor";
        // QueryBuilder for this clause
        $builder = $this->getQueryBuilder($field["builder"]);
        // alias
        $alias = $this->getAlias($builder, $field["alias"]);

        foreach ($clause->getArguments() as $argument) {
            $this->$method($alias, $field["name"], $clause->getType(), $argument, $predicates, $parameters);
        }

        // predicates and arguments are set, add them to the relevant QueryBuilder
        $this->addQueryToBuilder($builder, $predicates, $parameters, $clause->getType() === "!");
    }

    /**
     * Process a generic code argument
     * 
     * @param string $fieldName
     * @param string $type
     * @param string $argument
     * @param array $predicates
     * @param array $parameters
     */
    private function codeProcessor ($alias, $fieldName, $type, $argument, &$predicates, &$parameters)
    {
        $index = $this->getNextIndex();
        $parameters[$index] = $argument;
        switch ($type) {
            case ":":
                $predicates[] = "($alias.$fieldName = ?$index)";
                break;
            case "!":
                $predicates[] = "($alias.$fieldName != ?$index)";
                break;
        }
    }

    /**
     * Process a generic string argument
     * 
     * @param string $fieldName
     * @param string $type
     * @param string $argument
     * @param array $predicates
     * @param array $parameters
     */
    private function stringProcessor ($alias, $fieldName, $type, $argument, &$predicates, &$parameters)
    {
        $index = $this->getNextIndex();
        $parameters[$index] = "%$argument%";
        switch ($type) {
            case ":":
                $predicates[] = "($alias.$fieldName like ?$index)";
                break;
            case "!":
                $predicates[] = "($alias.$fieldName is null or $alias.$fieldName not like ?$index)";
                break;
        }
    }

    /**
     * Process an generic integer argument
     * 
     * @param string $fieldName
     * @param string $type
     * @param string $argument
     * @param array $predicates
     * @param array $parameters
     */
    private function integerProcessor ($alias, $fieldName, $type, $argument, &$predicates, &$parameters)
    {
        $index = $this->getNextIndex();
        $parameters[$index] = $argument;
        switch ($type) {
            case ":":
                $predicates[] = "($alias.$fieldName = ?$index)";
                break;
            case "!":
                $predicates[] = "($alias.$fieldName != ?$index)";
                break;
            case "<":
                $predicates[] = "($alias.$fieldName < ?$index)";
                break;
            case ">":
                $predicates[] = "($alias.$fieldName > ?$index)";
                break;
        }
    }

    /**
     * Process a generic boolean argument
     * 
     * @param string $fieldName
     * @param string $type
     * @param string $argument
     * @param array $predicates
     * @param array $parameters
     */
    private function booleanProcessor ($alias, $fieldName, $type, $argument, &$predicates, &$parameters)
    {
        $index = $this->getNextIndex();
        $parameters[$index] = boolval($argument);
        switch ($type) {
            case ":":
                $predicates[] = "($alias.$fieldName = ?$index)";
                break;
            case "!":
                $predicates[] = "($alias.$fieldName != ?$index)";
                break;
        }
    }

    /**
     * Add a "where" DQL string to any builder
     * 
     * @param \Doctrine\ORM\QueryBuilder $builder
     * @param array $predicates
     * @param array $parameters
     * @param boolean $negative
     */
    public function addQueryToBuilder (\Doctrine\ORM\QueryBuilder $builder, $predicates, $parameters, $negative = FALSE)
    {
        $builder->andWhere(implode($negative ? " and " : " or ", $predicates));

        foreach ($parameters as $index => $parameter) {
            $this->cardBuilder->setParameter($index, $parameter);
        }
    }

    /**
     * 
     * @param string $root
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function getQueryBuilder ($root)
    {
        $builder = $root . "Builder";
        $generator = $builder . "Generator";
        return $this->$generator();
    }

    /**
     * Return the alias used in the DQL for this entity (as configured in QueryMapper)
     * 
     * @param \Doctrine\ORM\QueryBuilder $builder
     * @param integer $aliasPosition
     * @return string
     */
    private function getAlias (\Doctrine\ORM\QueryBuilder $builder, $aliasPosition)
    {
        return $builder->getAllAliases()[$aliasPosition];
    }

    /**
     * Creates the Card QueryBuilder
     */
    private function cardBuilderGenerator ()
    {
        return $this->cardBuilder;
    }

    /**
     * Creates the Pack QueryBuilder
     */
    private function packBuilderGenerator ()
    {
        $i = count($this->builders);

        $builder = $this->entityManager->createQueryBuilder()
                ->select("pc$i")
                ->from("AppBundle:PackCard", "pc$i")
                ->leftJoin("pc$i.pack", "p$i")
                ->leftJoin("p$i.cycle", "y$i")
                ->where("pc$i.card = c0")
        ;

        $this->builders[] = $builder;

        return $builder;
    }

    /*
     * Creates the Dice QueryBuilder
     */

    private function diceBuilderGenerator ()
    {
        $i = count($this->builders);

        $builder = $this->entityManager->createQueryBuilder()
                ->select("cd$i")
                ->from("AppBundle:CardDice", "cd$i")
                ->leftJoin("cd$i.dice", "d$i")
                ->where("cd$i.card = c0")
        ;

        $this->builders[] = $builder;

        return $builder;
    }

}
