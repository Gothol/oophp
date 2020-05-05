<?php
/**
* Class to handle a round in the game.
*/

namespace Joel\Dice;

class Round
{
    /**
    * @var Dicehand $hand instance of the class Dicehand.
    * @var int $sum The total score for a player in this particular game.
    * @var int $res the result in this particular rund, combination of sum from rolled dicehands.
    * @var string $headline Headline for the rendered page, user inteface.
    * @var array $formValue array consisting of arrays with strings for use in rendering forms in user interface.
    * @var string $message, to be used as a flash-message in user interface.
    */
    private $hand;
    private $sum;
    private $res;
    private $headline;
    private $formValue;
    private $message;

    /**
    * Construct to start a new round in the game.
    * @var int $dices the number om dices that a dicehand should consist of defaults to 2.
    * @var int $sum the total score from previous rounds default to 0.
    * @var int $res the total sum from previous rolls this round defaults to 0.
    * @var string $headline the headline to show, defaults to "".
    * @var array $formValue the array of arguments for the userinterface-buttons, defaults to empty array.
    * @var string $message flash message defaults to "".
    */
    public function __construct(int $dices = 2, int $sum = 0, int $res = 0, string $headline = "", array $formValue = [], string $message = "")
    {
        $this->hand = new Dicehand($dices);
        $this->sum = $sum;
        $this->res = $res;
        $this->headline = $headline;
        $this->formValue = [];
        $this->message = "";
    }

    /**
    * Rolls the number of dices that a dicehand consists of.
    * @return void.
    */
    public function rollHand()
    {
        $this->hand->roll();
    }

    /**
    * @return array $values the values of the dices in the current hand.
    */
    public function values()
    {
        return $this->hand->values();
    }

    /**
    * Checks if the dice hand includes a one or not. If it do set $res to 0 else adds the value of the dices to $res.
    * Sets formvalue to match if you can continue a round or need to quit (rolled a 1).
    * @var string $palyer tells if it's a player or a computer that plays the current round.
    * @return void.
    */
    public function check(string $player)
    {
        $check = True;
        foreach ($this->hand->values() as $key => $value)
        {
            if ($value === 1) {
                $check = False;
            }
        }
        if ($check)
        {
            $this->res = $this->res + $this->hand->sum();
            if ($player === "player")
            {
                $this->formValue = [
                    "1" => [
                        "action" => "play_continue",
                        "submit" => "Roll the dice"
                    ],
                    "2" => [
                        "action" => "end_turn_player",
                        "submit" => "End turn"
                    ]
                ];
            } else {
                $this->formValue = [
                    "1" => [
                        "action" => "play_computer_proc",
                        "submit" => "Roll the dice"
                    ]
                ];
            }
        } else {
            $this->res = 0;
            if ($player === "player") {
                $this->formValue = [
                    "1" => [
                        "action" => "end_turn_player",
                        "submit" => "End turn"
                    ]
                ];
                $this->message = "You rolled a 1, end the turn to let the computer play.";
            } else {
                $this->formValue = [
                    "1" => [
                        "action" => "end_turn_computer",
                        "submit" => "End turn"
                    ]
                ];
                $this->message = "Computer rolled a 1, end the turn to take your turn.";
            }
        }
    }

    /**
    * @return int $res The combined result of all hands this round.
    */
    public function getResult()
    {
        return $this->res;
    }

    /**
    * @return int $sum the total score for this player so far.
    */
    public function getTotal()
    {
        $this->sum = $this->sum + $this->res;
        return $this->sum;
    }

    /**
    * @return array $formValue values for the forms with submitbuttons in the UI.
    */
    public function getForm()
    {
        return $this->formValue;
    }

    /**
    * Sets the values for $formValue
    * @var string $action string with routename for submitbutton.
    * @var string $submit string with text on submitbutton.
    */
    public function setForm($action, $submit)
    {
        $this->formValue = [
            "1" => [
                "action" => $action,
                "submit" => $submit
            ]
        ];
    }

    /**
    * Checks if current roll sends a player to or above 100 points.
    * @var string $player string to tell wich player that is playing (player or computer).
    * @return string $headline String to use as headline in the UI.
    */
    public function checkSum($player)
    {
        if(($this->sum + $this->res) >= 100) {
            if ($player === "player") {
                $this->headline = "You win!";
                $this->formValue = [];
            } else {
                $this->headline = "You lose!";
                $this->formValue = [];
            }
        } else {
            $this->headline = "Play dice";
        }
        return $this->headline;
    }

    /**
    * @return array array with string-names to use as classes to show graphics of dices.
    */
    public function getGraphic()
    {
        return $this->hand->getGraphics();
    }

    /**
    * @return array $message. Falshmessage to use in the UI.
    */
    public function getMess()
    {
        return $this->message;
    }
}
