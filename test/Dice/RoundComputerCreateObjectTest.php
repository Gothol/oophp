<?php

namespace Joel\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class RoundComputerCreateObjectTest extends TestCase
{
    /**
    * Test case with 3 stated argument.
    */
    public function testCreateObject3Arguments()
    {
        $round = new RoundComputer(3, 15, 10);
        $this->assertInstanceOf("\Joel\Dice\RoundComputer", $round);

        $sequence = [];
        $round->rollHand100($sequence);
        $values = $round->values();
        $sequence = $round->getHistogramSequence();
        $this->assertIsArray($values);
        $this->assertCount(3, $values);
        $this->assertCount(3, $sequence);

        $res = $round->getTotal();
        $exp = 25;
        $this->assertEquals($res, $exp);

        $res = $round->getResult();
        $exp = 10;
        $this->assertEquals($res, $exp);

        $res = $round->getForm();
        $exp = [];
        $this->assertEquals($res, $exp);

        $res = $round->getMess();
        $exp = "";
        $this->assertEquals($res, $exp);
    }

    /**
    * Test case with 2 stated arguments
    */
    public function testCreateObjectTwoArguments()
    {
        $round = new RoundComputer(3, 15);
        $this->assertInstanceOf("\Joel\Dice\RoundComputer", $round);

        $sequence = [];
        $round->rollHand100($sequence);
        $values = $round->values();
        $sequence = $round->getHistogramSequence();
        $this->assertIsArray($values);
        $this->assertCount(3, $values);
        $this->assertCount(3, $sequence);

        $res = $round->getTotal();
        $exp = 15;
        $this->assertEquals($res, $exp);

        $res = $round->getResult();
        $exp = 0;
        $this->assertEquals($res, $exp);

        $res = $round->getForm();
        $exp = [];
        $this->assertEquals($res, $exp);

        $res = $round->getMess();
        $exp = "";
        $this->assertEquals($res, $exp);
    }

    /**
    * Test case with 1 stated arguments
    */
    public function testCreateObjectOneArgument()
    {
        $round = new RoundComputer(3);
        $this->assertInstanceOf("\Joel\Dice\RoundComputer", $round);

        $sequence = [];
        $round->rollHand100($sequence);
        $values = $round->values();
        $sequence = $round->getHistogramSequence();
        $this->assertIsArray($values);
        $this->assertCount(3, $values);
        $this->assertCount(3, $sequence);

        $res = $round->getTotal();
        $exp = 0;
        $this->assertEquals($res, $exp);

        $res = $round->getResult();
        $exp = 0;
        $this->assertEquals($res, $exp);

        $res = $round->getForm();
        $exp = [];
        $this->assertEquals($res, $exp);

        $res = $round->getMess();
        $exp = "";
        $this->assertEquals($res, $exp);
    }

    /**
    * Test case with no stated arguments
    */
    public function testCreateObjectNoArgument()
    {
        $round = new RoundComputer();
        $this->assertInstanceOf("\Joel\Dice\RoundComputer", $round);

        $sequence = [];
        $round->rollHand100($sequence);
        $values = $round->values();
        $sequence = $round->getHistogramSequence();
        $this->assertIsArray($values);
        $this->assertCount(2, $values);
        $this->assertCount(2, $sequence);

        $res = $round->getTotal();
        $exp = 0;
        $this->assertEquals($res, $exp);

        $res = $round->getResult();
        $exp = 0;
        $this->assertEquals($res, $exp);

        $res = $round->getForm();
        $exp = [];
        $this->assertEquals($res, $exp);

        $res = $round->getMess();
        $exp = "";
        $this->assertEquals($res, $exp);
    }
}
