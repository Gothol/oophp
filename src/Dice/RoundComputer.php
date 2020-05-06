<?php
/**
* Subclass of Round to handle computer intelligens.
*/
namespace Joel\Dice;

class RoundComputer extends Round
{
    /**
    * Construct of round.
    */
    public function __construct(int $dices = 2, int $sum = 0, int $res = 0)
    {
        parent::__construct($dices, $sum, $res);
    }

    /**
    * Checks if the computer should roll another hand or end the turn, based on the score of this round.
    * @return void
    */
    public function checkRes()
    {
        if ($this->getResult() > 15) {
            $action = "end_turn_computer";
            $submit = "End turn";
            $this->setForm($action, $submit);
        }
    }
}
