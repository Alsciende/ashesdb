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
    private $qbCard;

    /**
     *
     * @var \Doctrine\ORM\QueryBuilder
     */
    private $qbPack;

    /**
     *
     * @var \Doctrine\ORM\QueryBuilder
     */
    private $qbDice;
    
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

    /**
     * 
     * @param \AppBundle\Parser\QueryClause[] $clauses
     * @param string $sortOrder
     * @return \Doctrine\ORM\Query
     */
    public function getQuery (array $clauses = [], string $sortOrder = 'name')
    {
        $this->qbCard = $this->entityManager->createQueryBuilder()
                ->select('c')
                ->from('AppBundle:Card', 'c')
        ;
        
        $this->index = 0;
        
        foreach($clauses as $clause) {
            $this->processClause($clause);
        }
        
        return $this->qbCard->getQuery();
    }
    
    public function getNextIndex()
    {
        return $this->index++;
    }
    
    private function processClause(QueryClause $clause)
    {
        $field = $this->queryMapper->getField($clause->getName());
        if($field === FALSE) {
            return;
        }
        switch($field['type']) {
            case 'string':
                $this->processStringClause($clause->getName(), $field['name'], $clause->getType(), $clause->getArguments());
                break;
        }
        
    }
    
    private function processStringClause($clauseName, $fieldName, $type, $arguments)
    {
        $disjonction = [];
        foreach($arguments as $argument) {
            $index = $this->getNextIndex();
            $this->qbCard->setParameter($index, "%$argument%");
            switch($type) {
                case ':':
                    $disjonction[] = "(c.$fieldName like ?$index)";
                    break;
                case '!':
                    $disjonction[] = "(c.$fieldName is null or c.$fieldName not like ?$index)";
                    break;
            }
        }
        $operator = ($type === ':' ? "and" : "or");
        $this->qbCard->andWhere(implode(" $operator ", $disjonction));
    }
    
    
    
    
    

    private function addPackJoin ()
    {
        if(isset($this->qbPack)) {
            return;
        }
        
        $this->qbPack = $this->entityManager->createQueryBuilder()
                ->select('pc')
                ->from('AppBundle:PackCard', 'pc')
                ->leftJoin('pc.pack', 'p')
                ->leftJoin('p.cycle', 'y')
                ->where('pc.card = c')
        ;

        $this->qbCard
                ->andWhere($this->qbCard->expr()->exists($this->qbPack->getDQL()));
    }

    private function addDiceJoin ()
    {
        if(isset($this->qbDice)) {
            return;
        }
        
        $this->qbDice = $this->entityManager->createQueryBuilder()
                ->select('cd')
                ->from('AppBundle:CardDice', 'cd')
                ->leftJoin('cd.dice', 'd')
                ->where('cd.card = c')
        ;

        $this->qbCard
                ->andWhere($this->qbCard->expr()->exists($this->qbDice->getDQL()))
        ;
    }

}
