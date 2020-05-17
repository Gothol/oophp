<?php

namespace Joel\Diceold;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class StartingPlayerCreateObjectTest extends TestCase
{
    /**
    * Test case with no argument
    */
    public function testCreateObjectArgument()
    {
        $startingPlayer = new StartingPlayer();
        $this->assertInstanceOf("\Joel\Diceold\StartingPlayer", $startingPlayer);

        $res = $startingPlayer->getMess();
        $exp = null;
        $this->assertEquals($res, $exp);

        $res = $startingPlayer->getForm();
        $exp = [];
        $this->assertEquals($res, $exp);

        $res = $startingPlayer->rollDiePlayer();
        $this->assertGreaterThanOrEqual(1, $res);
        $this->assertLessThanOrEqual(6, $res);

        $res = $startingPlayer->rollDieComputer();
        $this->assertGreaterThanOrEqual(1, $res);
        $this->assertLessThanOrEqual(6, $res);
    }
}
