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
    private $builders = [];

    /**
     *
     * @var integer
     */
    private $index;

    public function __construct (\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->queryMapper = new QueryMapper();
    }

    public function getNextIndex ()
    {
        return $this->index++;
    }

    /**
     * Take an array of QueryClause and transform them into a Doctrine ORM Query
     * 
     * @param \AppBundle\Parser\QueryClause[] $clauses
     * @param string $sortOrder
     * @return \Doctrine\ORM\Query
     */
    public function getQuery (array $clauses = [], string $sortOrder = "name")
    {
        $this->cardBuilder = $this->entityManager->createQueryBuilder()
                ->select("c")
                ->from("AppBundle:Card", "c")
        ;
        $this->index = 0;

        // process each QueryClause to add DQL to one of the QueryBuilders
        foreach ($clauses as $clause) {
            $this->processClause($clause);
        }

        // add all additional builders used during the process to the main QueryBuilder
        foreach ($this->builders as $builder) {
            $this->cardBuilder->andWhere($this->cardBuilder->expr()->exists($builder->getDQL()));
        }
        
        // return the ORM Query
        return $this->cardBuilder->getQuery();
    }

    /**
     * Process one QueryClause by adding the relevant DQL to a QueryBuilder
     * 
     * @param \AppBundle\Query\QueryClause $clause
     */
    private function processClause (QueryClause $clause)
    {
        // use the QueryMapper to have information about the clause
        $field = $this->queryMapper->getField($clause->getName());

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
        // which QueryBuilder will we add the DQL to
        $root = isset($field["root"]) ? $field["root"] : "card";
        // QueryBuilder for this clause
        $builder = $this->getQueryBuilder($root);
        // alias
        $alias = $root === 'card' ? 'c' : $builder->getAllAliases()[1]; // magic
        
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
    private function getQueryBuilder($root)
    {
        $builder = $root . "Builder";
        $generator = $builder . "Generator";
        return $this->$generator();
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
                ->where("pc$i.card = c")
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
                ->where("cd$i.card = c")
        ;
        
        $this->builders[] = $builder;
        
        return $builder;
    }

}
