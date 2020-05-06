<?php

namespace Joel\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DicehandMethodsTest extends TestCase
{
    /**
    * Test case with stated argument.
    */
    public function testSumt()
    {
        $dicehand = new Dicehand();
        $this->assertInstanceOf("\Joel\Dice\Dicehand", $dicehand);

        $res = 0;
        $dicehand->roll();
        $values = $dicehand->values();
        $this->assertIsArray($values);
        $this->assertCount(2, $values);
        for ($i = 0; $i < 2; $i++) {
            $res = $res + $values[$i];
            $this->assertGreaterThanOrEqual(1, $values[$i]);
            $this->assertLessThanOrEqual(6, $values[$i]);
        }
        $exp = $dicehand->sum();
        $this->assertGreaterThanOrEqual(2, $exp);
        $this->assertLessThanOrEqual(12, $exp);
        $this->assertEquals($exp, $res);
    }

    public function testGetGraphicsArgument()
    {
        $dicehand = new Dicehand();
        $this->assertInstanceOf("\Joel\Dice\Dicehand", $dicehand);

        $dicehand->roll();
        $values = $dicehand->values();
        $graphics = $dicehand->getGraphics();
        for ($i = 0; $i < 2; $i++) {
            $test1 = "dice-" . $values[$i];
            $test2 = $graphics[$i];
            $this->assertEquals($test1, $test2);
        }
    }
}
