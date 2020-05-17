<?php
/**
* Subclass of Round to handle computer intelligens.
*/
namespace Joel\Dice;

class RoundComputer extends Round
{
    protected $dices;
    /**
    * Construct of round.
    */
    public function __construct(int $dices = 2, int $sum = 0, int $res = 0)
    {
        parent::__construct($dices, $sum, $res);
        $this->dices = $dices;
    }

    /**
    * Checks if the computer should roll another hand or end the turn, based on the score of this round.
    * @return void
    */
    public function checkRes()
    {

        if ($this->getResult() > 15) {
            $action = "endTurnComputer";
            $submit = "End turn";
            $this->setForm($action, $submit);
        }
    }

    public function getProb()
    {
        $amount = $this->dices;
        $sides = 6;

        $prob = (($sides-1)**($amount))/($sides**($amount));

        return $prob;
    }

    public function getDecision()
    {
        $sides = 6;
        $expvalue = (2+$sides)/2;
        $waitvalue = $expvalue * $this->dices * $this->getProb();
        $waitloss = $this->getResult() * (1 - $this->getprob());
        $decision = $waitvalue / $waitloss;

        return $decision;
    }

    public function endTurn()
    {
        $action = "endTurnComputer";
        $submit = "End turn";
        $this->setForm($action, $submit);
    }

    public function checkIntRes($playsum)
    {
        $endValue = $playsum - $this->sum;

        if ($this->getResult() > 0) {
            $dec = $this->getDecision();
            if ($endValue <= 15) {
                if ($dec < 1.1) {
                    $this->endTurn();
                }
            } elseif (($endValue * $dec) < 15) {
                $this->endTurn();
            } /*elseif ($endValue > 20 and $dec < 0.8) {
                $this->endTurn();
            } elseif ($endValue > 25  and $dec < 0.6) {
                $this->endTurn();
            } /*elseif ($endValue > 30  and $dec < 0.5) {
                $this->endTurn();
            }*/
        }
        //return $endValue;
    }
}
