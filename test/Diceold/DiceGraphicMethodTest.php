<?php

namespace Joel\Diceold;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceGraphicMethodtTest extends TestCase
{
    /**
    * Test case of constructing object no argument
    */

    public function testGetGraphicArgument()
    {
        $diceGraphic = new DiceGraphic();
        $this->assertInstanceOf("\Joel\Diceold\DiceGraphic", $diceGraphic);

        $test1 = "dice-" . $diceGraphic->rollDie();
        $test2 = $diceGraphic->graphic();
        $this->assertEquals($test1, $test2);
    }
}
