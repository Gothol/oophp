<?php
/**
* Class to roll a die.
*/

namespace Joel\Dice;

class Dice
{
    private $sides;
    private $lastroll;

    /**
    * Constructs dice with variable number of sides.
    * @var int $sides sets the number of sides defaults to 6.
    */
    public function __construct(int $sides = 6)
    {
        $this->sides = $sides;
        $this->lastroll = null;
    }

    /**
    * rolls the the die. randomises a value between 1 and the number of sides.
    * @return integer
    */
    public function rollDie()
    {
        $this->lastroll = rand(1, $this->sides);
        return $this->lastroll;
    }

    /**
    * @return int $result the value of the die.
    */
    public function getLastRoll()
    {
        return $this->lastroll;
    }
}
