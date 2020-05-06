<?php

namespace Joel\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class StartingPlayerMethodsTest extends TestCase
{
    /**
    * Test rollStart no Argument (arguments onlys for testingpurpose)
    */
    public function testRollstartNoArgument()
    {
        $startingPlayer = new StartingPlayer();
        $this->assertInstanceOf("\Joel\Dice\StartingPlayer", $startingPlayer);

        $startingPlayer->rollStart();
        $res = $startingPlayer->getMess();
        $this->assertIsString($res);
        $this->assertStringStartsWith("Player rolls ", $res);
        $this->assertStringEndsWith("starts.", $res);

        $res = $startingPlayer->getForm();
        $this->assertIsArray($res);
    }

    /**
    * Test rollStart player wins (arguments onlys for testingpurpose)
    */
    public function testRollStartPlayerWins()
    {
        $startingPlayer = new StartingPlayer(6, 0);
        $this->assertInstanceOf("\Joel\Dice\StartingPlayer", $startingPlayer);
        $startingPlayer->rollStart();
        $res = $startingPlayer->getMess();
        $this->assertIsString($res);
        $this->assertStringStartsWith("Player rolls ", $res);
        $this->assertStringEndsWith("<br>Player starts.", $res);

        $res = $startingPlayer->getForm();
        $this->assertIsArray($res);
        $exp = [
            "1" => [
                "action" => "play_continue",
                "submit" => "Roll the dice"
            ],
            "2" => [
                "action" => "end_turn_player",
                "submit" => "End turn"
            ]
        ];
        $this->assertEquals($res, $exp);
    }

    /**
    * Test rollStart computer wins (arguments onlys for testingpurpose)
    */
    public function testRollStartComputerWins()
    {
        $startingPlayer = new StartingPlayer(0, 10);
        $this->assertInstanceOf("\Joel\Dice\StartingPlayer", $startingPlayer);

        $startingPlayer->rollStart();
        $res = $startingPlayer->getMess();
        $this->assertIsString($res);
        $this->assertStringStartsWith("Player rolls ", $res);
        $this->assertStringEndsWith("<br>Computer starts.", $res);

        $res = $startingPlayer->getForm();
        $this->assertIsArray($res);
        $exp = [
            "1" => [
                "action" => "play_computer_proc",
                "submit" => "Roll the dice"
            ]
        ];
        $this->assertEquals($res, $exp);
    }
}
