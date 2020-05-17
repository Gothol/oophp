<?php

namespace Joel\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class RoundComputerMethodsTest extends TestCase
{
    /**
    * Test checkRes when res is less than 15.
    */
    public function testCheckResLessThanFifteen()
    {
        $round = new RoundComputer(2, 10, 10);
        $this->assertInstanceOf("\Joel\Dice\RoundComputer", $round);

        $round->checkRes();

        $res = $round->getForm();
        $exp = [];
        $this->assertEquals($res, $exp);
    }

    /**
    * Test checkRes when res is greater than 15
    */
    public function testCheckSumGreaterThanFifteen()
    {
        $round = new RoundComputer(3, 15, 20);
        $this->assertInstanceOf("\Joel\Dice\RoundComputer", $round);

        $round->checkRes();

        $res = $round->getForm();
        $exp = [
            "1" => [
                "action" => "endTurnComputer",
                "submit" => "End turn"
            ]
        ];
        $this->assertEquals($res, $exp);
    }

    /**
    * Test getProb
    */
    public function testGetProb()
    {
        $round = new RoundComputer(2, 15, 20);
        $this->assertInstanceOf("\Joel\Dice\RoundComputer", $round);

        $res = $round->getProb();
        $exp = (5*5) / (6*6);
        $this->assertEqualsWithDelta($res, $exp, 0.001);
    }

    /**
    * Test getDecision
    */
    public function testGetDecision()
    {
        $round = new RoundComputer(2, 15, 20);
        $this->assertInstanceOf("\Joel\Dice\RoundComputer", $round);

        $res = $round->getDecision();
        $exp = 0.90909;
        $this->assertEqualsWithDelta($res, $exp, 0.001);
    }
    /**
    * Test CheckIntRes Computer in lead end turn.
    */
    public function testCheckIntResComputerInleadEndTurn()
    {
        $round = new RoundComputer(2, 15, 20);
        $this->assertInstanceOf("\Joel\Dice\RoundComputer", $round);

        $round->checkIntRes(0);
        $res = $round->getForm();
        $exp = [
            "1" => [
                "action" => "endTurnComputer",
                "submit" => "End turn"
            ]
        ];
        $this->assertEquals($exp, $res);
    }

    /**
    * Test CheckIntRes Computer in lead continue.
    */
    public function testCheckIntResComputerInleadContinue()
    {
        $round = new RoundComputer(2, 15, 10);
        $this->assertInstanceOf("\Joel\Dice\RoundComputer", $round);

        $round->checkIntRes(0);
        $res = $round->getForm();
        $exp = [
            "1" => [
                "action" => "endTurnComputer",
                "submit" => "End turn"
            ]
        ];
        $this->assertNotEquals($exp, $res);
    }
    /**
    * Test CheckIntRes Computer not in lead end turn. Player lead with more than 20
    */
    public function testCheckIntResComputerNotInleadEndTurn()
    {
        $round = new RoundComputer(2, 15, 32);
        $this->assertInstanceOf("\Joel\Dice\RoundComputer", $round);

        $round->checkIntRes(40);
        $res = $round->getForm();
        $exp = [
            "1" => [
                "action" => "endTurnComputer",
                "submit" => "End turn"
            ]
        ];
        $this->assertEquals($exp, $res);
    }

    /**
    * Test CheckIntRes Computer not in lead continue. Player lead with more than 20
    */
    public function testCheckIntResComputerNotInleadContinue()
    {
        $round = new RoundComputer(2, 15, 20);
        $this->assertInstanceOf("\Joel\Dice\RoundComputer", $round);

        $round->checkIntRes(40);
        $res = $round->getForm();
        $exp = [
            "1" => [
                "action" => "endTurnComputer",
                "submit" => "End turn"
            ]
        ];
        $this->assertNotEquals($exp, $res);
    }
}
