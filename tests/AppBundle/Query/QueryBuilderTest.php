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
        $builder = new \AppBundle\Query\QueryBuilder($this->em, new \AppBundle\Query\QueryMapper());
        $query = $builder->getQuery(new AppBundle\Query\QueryInput($clauses));
        return $query;
    }

    public function testGetQuery1 ()
    {
        $query = $this->getQuery();
        $this->assertEquals("SELECT c0, c1, c2, c3 FROM AppBundle:Card c0 LEFT JOIN c0.conjuring c1 LEFT JOIN c0.conjuredBy c2 LEFT JOIN c0.exclusiveTo c3 ORDER BY c0.name ASC", $query->getDQL());
    }

    public function testGetQuery2 ()
    {
        $query = $this->getQuery(array(
            new \AppBundle\Query\QueryClause("", ":", ["Coal Roarkwin"])
        ));
        $this->assertEquals("SELECT c0, c1, c2, c3 FROM AppBundle:Card c0 LEFT JOIN c0.conjuring c1 LEFT JOIN c0.conjuredBy c2 LEFT JOIN c0.exclusiveTo c3 WHERE (c0.name like ?0) ORDER BY c0.name ASC", $query->getDQL());
    }

    public function testGetQuery3 ()
    {
        $query = $this->getQuery(array(
            new \AppBundle\Query\QueryClause("x", ":", ["deal 1 damage"])
        ));
        $this->assertEquals("SELECT c0, c1, c2, c3 FROM AppBundle:Card c0 LEFT JOIN c0.conjuring c1 LEFT JOIN c0.conjuredBy c2 LEFT JOIN c0.exclusiveTo c3 WHERE (c0.text like ?0) ORDER BY c0.name ASC", $query->getDQL());
    }

    public function testGetQuery4 ()
    {
        $query = $this->getQuery(array(
            new \AppBundle\Query\QueryClause("x", ":", ["Remove 1 wound token"]),
            new \AppBundle\Query\QueryClause("x", ":", ["Remove 1 exhaustion token"])
        ));
        $this->assertEquals("SELECT c0, c1, c2, c3 FROM AppBundle:Card c0 LEFT JOIN c0.conjuring c1 LEFT JOIN c0.conjuredBy c2 LEFT JOIN c0.exclusiveTo c3 WHERE (c0.text like ?0) AND (c0.text like ?1) ORDER BY c0.name ASC", $query->getDQL());
    }

    public function testGetQuery5 ()
    {
        $query = $this->getQuery(array(
            new \AppBundle\Query\QueryClause("a", "<", ["3"]),
            new \AppBundle\Query\QueryClause("l", ":", ["2"]),
            new \AppBundle\Query\QueryClause("r", ">", ["1"])
        ));
        $this->assertEquals("SELECT c0, c1, c2, c3 FROM AppBundle:Card c0 LEFT JOIN c0.conjuring c1 LEFT JOIN c0.conjuredBy c2 LEFT JOIN c0.exclusiveTo c3 WHERE (c0.attack < ?0) AND (c0.life = ?1) AND (c0.recover > ?2) ORDER BY c0.name ASC", $query->getDQL());
    }

    public function testGetQuery6 ()
    {
        $query = $this->getQuery(array(
            new \AppBundle\Query\QueryClause("p", ":", ["the-iron-men"])
        ));
        $this->assertEquals("SELECT c0, c1, c2, c3 FROM AppBundle:Card c0 LEFT JOIN c0.conjuring c1 LEFT JOIN c0.conjuredBy c2 LEFT JOIN c0.exclusiveTo c3 WHERE EXISTS(SELECT pc0 FROM AppBundle:PackCard pc0 LEFT JOIN pc0.pack p0 LEFT JOIN p0.cycle y0 WHERE pc0.card = c0 AND (p0.code = ?0)) ORDER BY c0.name ASC", $query->getDQL());
    }

    public function testGetQuery7 ()
    {
        $query = $this->getQuery(array(
            new \AppBundle\Query\QueryClause("d", ":", ["illusion"]),
            new \AppBundle\Query\QueryClause("d", ":", ["charm"])
        ));
        $this->assertEquals("SELECT c0, c1, c2, c3 FROM AppBundle:Card c0 LEFT JOIN c0.conjuring c1 LEFT JOIN c0.conjuredBy c2 LEFT JOIN c0.exclusiveTo c3 WHERE (EXISTS(SELECT cd0 FROM AppBundle:CardDice cd0 LEFT JOIN cd0.dice d0 WHERE cd0.card = c0 AND (d0.code = ?0))) AND (EXISTS(SELECT cd1 FROM AppBundle:CardDice cd1 LEFT JOIN cd1.dice d1 WHERE cd1.card = c0 AND (d1.code = ?1))) ORDER BY c0.name ASC", $query->getDQL());
    }
    
    public function testGetQuery8 ()
    {
        $query = $this->getQuery(array(
            new \AppBundle\Query\QueryClause("c", ":", ["ashes"])
        ));
        $this->assertEquals("SELECT c0, c1, c2, c3 FROM AppBundle:Card c0 LEFT JOIN c0.conjuring c1 LEFT JOIN c0.conjuredBy c2 LEFT JOIN c0.exclusiveTo c3 WHERE EXISTS(SELECT pc0 FROM AppBundle:PackCard pc0 LEFT JOIN pc0.pack p0 LEFT JOIN p0.cycle y0 WHERE pc0.card = c0 AND (y0.code = ?0)) ORDER BY c0.name ASC", $query->getDQL());
    }

    public function testGetQuery9 ()
    {
        $query = $this->getQuery(array(
            new \AppBundle\Query\QueryClause("c", ":", ["deluxe-sets"])
        ));
        $this->assertEquals("SELECT c0, c1, c2, c3 FROM AppBundle:Card c0 LEFT JOIN c0.conjuring c1 LEFT JOIN c0.conjuredBy c2 LEFT JOIN c0.exclusiveTo c3 WHERE EXISTS(SELECT pc0 FROM AppBundle:PackCard pc0 LEFT JOIN pc0.pack p0 LEFT JOIN p0.cycle y0 WHERE pc0.card = c0 AND (y0.code = ?0)) ORDER BY c0.name ASC", $query->getDQL());
    }

}
