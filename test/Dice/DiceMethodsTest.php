<?php

namespace Joel\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice method lastRoll.
 */
class DiceMethodsTest extends TestCase
{
    /**
    * Test case for getLastRoll.
    */
    public function testLastRoll()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Joel\Dice\Dice", $dice);

        $res = $dice->rollDie();
        $exp = $dice->getLastRoll();
        $this->assertEquals($exp, $res);
    }

    public function testGetSides()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Joel\Dice\Dice", $dice);

        $res = $dice->getSides();
        $exp = 6;
        $this->assertEquals($exp, $res);
    }
}
