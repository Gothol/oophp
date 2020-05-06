<?php

namespace Joel\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceGraphicCreateObjectTest extends TestCase
{
    /**
    * Test case of constructing object no argument
    */

    public function testCreateObjectNoArgument()
    {
        $diceGraphic = new DiceGraphic();
        $this->assertInstanceOf("\Joel\Dice\DiceGraphic", $diceGraphic);

        $res = $diceGraphic->rollDie();
        $this->assertGreaterThanOrEqual(1, $res);
        $this->assertLessThanOrEqual(6, $res);
    }
}
