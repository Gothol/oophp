<?php

namespace Joel\Diceold;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceCreateObjectTest extends TestCase
{
    /**
    * Test case with stated argument.
    */
    public function testCreateObjectArgument()
    {
        $dice = new Dice(8);
        $this->assertInstanceOf("\Joel\Diceold\Dice", $dice);

        $res = $dice->rollDie();
        $this->assertGreaterThanOrEqual(1, $res);
        $this->assertLessThanOrEqual(8, $res);
    }

    /**
    * Test case with no stated argument.
    */
    public function testCreateObjectNoArgument()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Joel\Diceold\Dice", $dice);

        $res = $dice->rollDie();
        $this->assertGreaterThanOrEqual(1, $res);
        $this->assertLessThanOrEqual(6, $res);
    }
}
