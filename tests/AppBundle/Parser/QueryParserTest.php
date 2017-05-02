<?php

/**
 * 
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class QueryParserTest extends \PHPUnit\Framework\TestCase
{

    public function testParse1 ()
    {
        $parser = new \AppBundle\Parser\QueryParser();
        $clauses = $parser->parse('Coal');
        $this->assertEquals(
                1, count($clauses)
        );
        /* @var $clause \AppBundle\Parser\QueryClause */
        $clause = $clauses[0];
        $this->assertEquals("", $clause->getName());
        $this->assertEquals(":", $clause->getType());
        $this->assertEquals("Coal", $clause->getArguments()[0]);
    }

    public function testParse2 ()
    {
        $parser = new \AppBundle\Parser\QueryParser();
        $clauses = $parser->parse('x:damage');
        $this->assertEquals(
                1, count($clauses)
        );
        /* @var $clause \AppBundle\Parser\QueryClause */
        $clause = $clauses[0];
        $this->assertEquals("x", $clause->getName());
        $this->assertEquals(":", $clause->getType());
        $this->assertEquals("damage", $clause->getArguments()[0]);
    }

    public function testParse3 ()
    {
        $parser = new \AppBundle\Parser\QueryParser();
        $clauses = $parser->parse('x:attack|defend');
        $this->assertEquals(
                1, count($clauses)
        );
        /* @var $clause \AppBundle\Parser\QueryClause */
        $clause = $clauses[0];
        $this->assertEquals("x", $clause->getName());
        $this->assertEquals(":", $clause->getType());
        $this->assertEquals("attack", $clause->getArguments()[0]);
        $this->assertEquals("defend", $clause->getArguments()[1]);
    }

    public function testParse4 ()
    {
        $parser = new \AppBundle\Parser\QueryParser();
        $clauses = $parser->parse('a>2');
        $this->assertEquals(
                1, count($clauses)
        );
        /* @var $clause \AppBundle\Parser\QueryClause */
        $clause = $clauses[0];
        $this->assertEquals("a", $clause->getName());
        $this->assertEquals(">", $clause->getType());
        $this->assertEquals("2", $clause->getArguments()[0]);
    }

    public function testParse5 ()
    {
        $parser = new \AppBundle\Parser\QueryParser();
        $clauses = $parser->parse('"Coal Roarkwin"');
        $this->assertEquals(
                1, count($clauses)
        );
        /* @var $clause \AppBundle\Parser\QueryClause */
        $clause = $clauses[0];
        $this->assertEquals("", $clause->getName());
        $this->assertEquals(":", $clause->getType());
        $this->assertEquals("Coal Roarkwin", $clause->getArguments()[0]);
    }

    public function testParse6 ()
    {
        $parser = new \AppBundle\Parser\QueryParser();
        $clauses = $parser->parse('x:"Remove 1 wound token"|"Remove 1 exhaustion token"');
        $this->assertEquals(
                1, count($clauses)
        );
        /* @var $clause \AppBundle\Parser\QueryClause */
        $clause = $clauses[0];
        $this->assertEquals("x", $clause->getName());
        $this->assertEquals(":", $clause->getType());
        $this->assertEquals("Remove 1 wound token", $clause->getArguments()[0]);
        $this->assertEquals("Remove 1 exhaustion token", $clause->getArguments()[1]);
    }

    public function testParse7 ()
    {
        $parser = new \AppBundle\Parser\QueryParser();
        $clauses = $parser->parse('a:2 l:2 r:0');
        $this->assertEquals(
                3, count($clauses)
        );
        list($clause1, $clause2, $clause3) = $clauses;
        /* @var $clause \AppBundle\Parser\QueryClause */
        $this->assertEquals("a", $clause1->getName());
        $this->assertEquals(":", $clause1->getType());
        $this->assertEquals("2", $clause1->getArguments()[0]);
        $this->assertEquals("l", $clause2->getName());
        $this->assertEquals(":", $clause2->getType());
        $this->assertEquals("2", $clause2->getArguments()[0]);
        $this->assertEquals("r", $clause3->getName());
        $this->assertEquals(":", $clause3->getType());
        $this->assertEquals("0", $clause3->getArguments()[0]);
    }

    public function testParse8 ()
    {
        $parser = new \AppBundle\Parser\QueryParser();
        $clauses = $parser->parse('Summon|Chant');
        $this->assertEquals(
                1, count($clauses)
        );
        /* @var $clause \AppBundle\Parser\QueryClause */
        $clause = $clauses[0];
        $this->assertEquals("", $clause->getName());
        $this->assertEquals(":", $clause->getType());
        $this->assertEquals("Summon", $clause->getArguments()[0]);
        $this->assertEquals("Chant", $clause->getArguments()[1]);
    }

}
