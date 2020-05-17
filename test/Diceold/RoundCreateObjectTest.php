<?php

namespace Joel\Diceold;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class RoundCreateObjectTest extends TestCase
{
    /**
    * Test case with 5 stated argument.
    */
    public function testCreateObject5Arguments()
    {
        $round = new Round(3, 15, 10, [
            "1" => [
                "action" => "play_continue",
                "submit" => "Roll the dice"
            ],
            "2" => [
                "action" => "end_turn_player",
                "submit" => "End turn"
            ]], "message");
        $this->assertInstanceOf("\Joel\Diceold\Round", $round);

        $round->rollHand();
        $values = $round->values();
        $this->assertIsArray($values);
        $this->assertCount(3, $values);

        $res = $round->getTotal();
        $exp = 25;
        $this->assertEquals($res, $exp);

        $res = $round->getResult();
        $exp = 10;
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
            ]];
        $this->assertEquals($res, $exp);

        $res = $round->getMess();
        $exp = "message";
        $this->assertEquals($res, $exp);
    }

    /**
    * Test case with 4 stated arguments
    */
    public function testCreateObjectFourArguments()
    {
        $round = new Round(3, 15, 10, [
            "1" => [
                "action" => "play_continue",
                "submit" => "Roll the dice"
            ],
            "2" => [
                "action" => "end_turn_player",
                "submit" => "End turn"
            ]]);
        $this->assertInstanceOf("\Joel\Diceold\Round", $round);

        $round->rollHand();
        $values = $round->values();
        $this->assertIsArray($values);
        $this->assertCount(3, $values);

        $res = $round->getTotal();
        $exp = 25;
        $this->assertEquals($res, $exp);

        $res = $round->getResult();
        $exp = 10;
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
            ]];
        $this->assertEquals($res, $exp);

        $res = $round->getMess();
        $exp = "";
        $this->assertEquals($res, $exp);
    }

    /**
    * Test case with 3 stated arguments
    */
    public function testCreateObjectThreeArguments()
    {
        $round = new Round(3, 15, 10);
        $this->assertInstanceOf("\Joel\Diceold\Round", $round);

        $round->rollHand();
        $values = $round->values();
        $this->assertIsArray($values);
        $this->assertCount(3, $values);

        $res = $round->getTotal();
        $exp = 25;
        $this->assertEquals($res, $exp);

        $res = $round->getResult();
        $exp = 10;
        $this->assertEquals($res, $exp);

        $res = $round->getForm();
        $exp = [];
        $this->assertEquals($res, $exp);

        $res = $round->getMess();
        $exp = "";
        $this->assertEquals($res, $exp);
    }

    /**
    * Test case with 2 stated arguments
    */
    public function testCreateObjectTwoArguments()
    {
        $round = new Round(3, 15);
        $this->assertInstanceOf("\Joel\Diceold\Round", $round);

        $round->rollHand();
        $values = $round->values();
        $this->assertIsArray($values);
        $this->assertCount(3, $values);

        $res = $round->getTotal();
        $exp = 15;
        $this->assertEquals($res, $exp);

        $res = $round->getResult();
        $exp = 0;
        $this->assertEquals($res, $exp);

        $res = $round->getForm();
        $exp = [];
        $this->assertEquals($res, $exp);

        $res = $round->getMess();
        $exp = "";
        $this->assertEquals($res, $exp);
    }

    /**
    * Test case with 1 stated arguments
    */
    public function testCreateObjectOneArgument()
    {
        $round = new Round(3);
        $this->assertInstanceOf("\Joel\Diceold\Round", $round);

        $round->rollHand();
        $values = $round->values();
        $this->assertIsArray($values);
        $this->assertCount(3, $values);

        $res = $round->getTotal();
        $exp = 0;
        $this->assertEquals($res, $exp);

        $res = $round->getResult();
        $exp = 0;
        $this->assertEquals($res, $exp);

        $res = $round->getForm();
        $exp = [];
        $this->assertEquals($res, $exp);

        $res = $round->getMess();
        $exp = "";
        $this->assertEquals($res, $exp);
    }

    /**
    * Test case with no stated arguments
    */
    public function testCreateObjectNoArgument()
    {
        $round = new Round();
        $this->assertInstanceOf("\Joel\Diceold\Round", $round);

        $round->rollHand();
        $values = $round->values();
        $this->assertIsArray($values);
        $this->assertCount(2, $values);

        $res = $round->getTotal();
        $exp = 0;
        $this->assertEquals($res, $exp);

        $res = $round->getResult();
        $exp = 0;
        $this->assertEquals($res, $exp);

        $res = $round->getForm();
        $exp = [];
        $this->assertEquals($res, $exp);

        $res = $round->getMess();
        $exp = "";
        $this->assertEquals($res, $exp);
    }
}
