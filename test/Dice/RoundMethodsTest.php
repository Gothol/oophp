<?php

namespace Joel\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class RoundMethodsTest extends TestCase
{
    /**
    * Test that a round with default values contains a hand of 2 dices,
    * where the dices has a value between 1 and 6.
    */
    public function testRollHand()
    {
        $round = new Round();
        $this->assertInstanceOf("\Joel\Dice\Round", $round);

        $round->rollHand();
        $values = $round->values();
        $this->assertIsArray($values);
        $this->assertCount(2, $values);
        for ($i = 0; $i < 2; $i++) {
            $this->assertGreaterThanOrEqual(1, $values[$i]);
            $this->assertLessThanOrEqual(6, $values[$i]);
        }
    }

    /**
    * Test method check when a player and one of the dices has a value of 1.
    * $res set to 10 to verify that its 0 after the check.
    */
    public function testCheckPlayerValueOne()
    {
        $round = new Round(2, 15, 10);
        $this->assertInstanceOf("\Joel\Dice\Round", $round);

        $round->setHandValues([4, 1]);

        $round->check("player");

        $res = $round->getResult();
        $exp = 0;
        $this->assertEquals($res, $exp);

        $res = $round->getForm();
        $exp = [
            "1" => [
                "action" => "end_turn_player",
                "submit" => "End turn"
            ]];
        $this->assertEquals($res, $exp);

        $res = $round->getMess();
        $exp = "You rolled a 1, end the turn to let the computer play.";
        $this->assertEquals($res, $exp);
    }

    /**
    * Test method check when the computer plays and one of the dices has a value of 1.
    * $res set to 10 to verify that its 0 after the check.
    */
    public function testCheckComputerValueOne()
    {
        $round = new Round(2, 15, 10);
        $this->assertInstanceOf("\Joel\Dice\Round", $round);

        $round->setHandValues([4, 1]);

        $round->check("computer");

        $res = $round->getResult();
        $exp = 0;
        $this->assertEquals($res, $exp);

        $res = $round->getForm();
        $exp = [
            "1" => [
                "action" => "end_turn_computer",
                "submit" => "End turn"
            ]
        ];
        $this->assertEquals($res, $exp);

        $res = $round->getMess();
        $exp = "Computer rolled a 1, end the turn to take your turn.";
        $this->assertEquals($res, $exp);
    }
    /**
    * Test method check when a player and none of the dices has a value of 1.
    */
    public function testCheckPlayerValueNotOne()
    {
        $round = new Round(2, 15, 10);
        $this->assertInstanceOf("\Joel\Dice\Round", $round);

        $round->setHandValues([4, 2]);

        $round->check("player");

        $res = $round->getResult();
        $exp = 16;
        $this->assertEquals($res, $exp);

        $res = $round->getForm();
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

        $res = $round->getMess();
        $exp = "";
        $this->assertEquals($res, $exp);
    }

    /**
    * Test method check when the computer plays and none of the dices has a value of 1.
    */
    public function testCheckComputerValueNotOne()
    {
        $round = new Round(2, 15, 10);
        $this->assertInstanceOf("\Joel\Dice\Round", $round);

        $round->setHandValues([4, 2]);

        $round->check("computer");

        $res = $round->getResult();
        $exp = 16;
        $this->assertEquals($res, $exp);

        $res = $round->getForm();
        $exp = [
            "1" => [
                "action" => "play_computer_proc",
                "submit" => "Roll the dice"
            ]
        ];
        $this->assertEquals($res, $exp);

        $res = $round->getMess();
        $exp = "";
        $this->assertEquals($res, $exp);
    }

    /**
    * Test checkSum when a player and sum + res is less than 100.
    */
    public function testCheckSumPlayerNotHundred()
    {
        $round = new Round(2, 15, 10);

        $res = $round->checkSum("player");
        $exp = "Play dice";
        $this->assertEquals($res, $exp);
    }

    /**
    * Test checkSum when a computer and sum + res is less than 100.
    */
    public function testCheckSumComputerNotHundred()
    {
        $round = new Round(2, 15, 10);

        $res = $round->checkSum("computer");
        $exp = "Play dice";
        $this->assertEquals($res, $exp);
    }

    /**
    * Test checkSum when a player and sum + res is over 100.
    */
    public function testCheckSumPlayerHundred()
    {
        $round = new Round(2, 95, 10, [
            "1" => [
                "action" => "play_continue",
                "submit" => "Roll the dice"
            ],
            "2" => [
                "action" => "end_turn_player",
                "submit" => "End turn"
            ]]);

        $res = $round->checkSum("player");
        $exp = "You win!";
        $this->assertEquals($res, $exp);

        $res = $round->getForm();
        $exp = [];
        $this->assertEquals($res, $exp);
    }

    /**
    * Test checkSum when a computer and sum + res is over 100.
    */
    public function testCheckSumComputerHundred()
    {
        $round = new Round(2, 95, 10, [
            "1" => [
                "action" => "play_continue",
                "submit" => "Roll the dice"
            ],
            "2" => [
                "action" => "end_turn_player",
                "submit" => "End turn"
            ]]);

        $res = $round->checkSum("computer");
        $exp = "You lose!";
        $this->assertEquals($res, $exp);

        $res = $round->getForm();
        $exp = [];
        $this->assertEquals($res, $exp);
    }

    /**
    * Test getGraphic
    */
    public function testGetGraphic()
    {
        $round = new Round();
        $this->assertInstanceOf("\Joel\Dice\Round", $round);

        $round->rollHand();
        $values = $round->values();
        $graphics = $round->getGraphic();
        $this->assertIsArray($values);
        $this->assertCount(2, $values);
        for ($i = 0; $i < 2; $i++) {
            $this->assertGreaterThanOrEqual(1, $values[$i]);
            $this->assertLessThanOrEqual(6, $values[$i]);
            $this->assertStringStartsWith("dice-", $graphics[$i]);
            $this->assertStringEndsWith($values[$i], $graphics[$i]);
        }
    }
}
