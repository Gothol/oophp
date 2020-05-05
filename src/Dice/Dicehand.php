<?php
/**
* Class to roll a hand of dices.
*/

namespace Joel\Dice;

class Dicehand
{
    /**
    * @var Dice $dices array that consisting of instances of the class Dice.
    * @var int $values array consisting of the last dice-values.
    * @var string $graphics array consisting of classnames coresponding to the dice-values
    */
    private $dices;
    private $values;
    private $graphics;
    /**
    * Construct to roll a number of dices.
    * @param int $dices number of dices to roll defaults to 2.
    */
    public function __construct(int $dices = 2)
    {
        $this->dices = [];
        $this->values = [];
        $this->grapics = [];

        for ($i = 0; $i < $dices; $i++) {
            $this->dices[] = new DiceGraphic();
            $this->values = null;
            $this->graphics = null;
        }
    }

    /**
    * Rolls the hand of dices.
    * @return void
    */
    public function roll()
    {
        foreach ($this->dices as $key => $value) {
            $this->values[$key] = $value->rollDie();
            $this->graphics[$key] = $value->graphic();
        }
    }

    /**
    * @return array $values the values of the dices in the hand.
    */
    public function values()
    {
        return $this->values;
    }

    /**
    * @return int the sum of the dices in the hand.
    */
    public function sum()
    {
        return array_sum($this->values);
    }

    /**
    * @return array $graphics array consisting of strings coresponding to the dicevalues.
    */
    public function getGraphics()
    {
        return $this->graphics;
    }
}
