<?php
/**
* Subclass of Dice to show graphics.
*/
namespace Joel\Diceold;

class DiceGraphic extends Dice
{
    /**
    * @var int SIDE, number of sides on the dice
    */
    const SIDE = 6;
    /**
    * Construct for a dice with SIDE sides.
    */
    public function __construct()
    {
        parent::__construct(self::SIDE);
    }

    public function graphic()
    {
        return "dice-" . $this->getLastRoll();
    }
}
