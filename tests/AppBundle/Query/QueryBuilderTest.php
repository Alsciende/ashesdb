<?php

/**
 * Description of QueryBuilderTest
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class QueryBuilderTest extends \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    protected function setUp ()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
                ->get('doctrine')
                ->getManager();
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown ()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }

    /**
     * 
     * @param array $clauses
     * @return \Doctrine\ORM\Queryy
     */
    private function getQuery ($clauses = [])
    {
        $builder = new \AppBundle\Query\QueryBuilder($this->em);
        $query = $builder->getQuery($clauses);
//        Symfony\Component\VarDumper\VarDumper::dump($query->getDQL());
        return $query;
    }

    public function testGetQuery1 ()
    {
        $query = $this->getQuery();
        $this->assertEquals("SELECT c FROM AppBundle:Card c", $query->getDQL());
    }

    public function testGetQuery2 ()
    {
        $query = $this->getQuery(array(new \AppBundle\Query\QueryClause("", ":", ["Coal Roarkwin"])));
        $this->assertEquals("SELECT c FROM AppBundle:Card c WHERE (c.name like ?0)", $query->getDQL());
    }

    public function testGetQuery3 ()
    {
        $query = $this->getQuery(array(new \AppBundle\Query\QueryClause("x", ":", ["deal 1 damage"])));
        $this->assertEquals("SELECT c FROM AppBundle:Card c WHERE (c.text like ?0)", $query->getDQL());
    }

}
