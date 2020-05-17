<?php

namespace Joel\Diceold;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice method lastRoll.
 */
class DiceLastRollTest extends TestCase
{
    /**
    * Test case for getLastRoll.
    */
    public function testLastRoll()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Joel\Diceold\Dice", $dice);

        $res = $dice->rollDie();
        $exp = $dice->getLastRoll();
        $this->assertEquals($exp, $res);
    }
}
