<?php

namespace Joel\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DicehandCreateObjectTest extends TestCase
{
    /**
    * Test case with stated argument.
    */
    public function testCreateObjectArgument()
    {
        $dicehand = new Dicehand(3);
        $this->assertInstanceOf("\Joel\Dice\Dicehand", $dicehand);

        $dicehand->roll();
        $values = $dicehand->values();
        $this->assertIsArray($values);
        $this->assertCount(3, $values);

        $graphics = $dicehand->getGraphics();
        $this->assertIsArray($graphics);
        $this->assertCount(3, $graphics);
    }

    /**
    * Test case with no stated argument.
    */
    public function testCreateObjectNoArgument()
    {
        $dicehand = new Dicehand();
        $this->assertInstanceOf("\Joel\Dice\Dicehand", $dicehand);

        $dicehand->roll();
        $values = $dicehand->values();
        $this->assertIsArray($values);
        $this->assertCount(2, $values);

        $graphics = $dicehand->getGraphics();
        $this->assertIsArray($graphics);
        $this->assertCount(2, $graphics);
    }
}
