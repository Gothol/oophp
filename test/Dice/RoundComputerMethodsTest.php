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
                "action" => "end_turn_computer",
                "submit" => "End turn"
            ]
        ];
        $this->assertEquals($res, $exp);
    }
}
