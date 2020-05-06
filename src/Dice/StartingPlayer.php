<?php
/**
* Class to determine starting player.
*/

namespace Joel\Dice;

class StartingPlayer
{
    /**
    * @var string $message flash message for the UI.
    * @var DiceGraphic $player instance of the class DiceGraphic, subclass of Dices.
    * @var DiceGraphic $computer instance of the class DiceGraphic, subclass of Dices.
    * @var array $formValue array consisting of arrays with strings for use in rendering forms in user interface.
    */
    private $message;
    private $player;
    private $computer;
    private $formValue;

    /**
    * Construct of starting player.
    * @var string $message flashmessage for the UI deafults to null.
    * @var array $formValue array consisting of arrays with strings for use in
    * rendering forms in user interface. defaults to [].
    * @var DiceGraphic $player instance of the class DiceGraphic, subclass of Dices.
    * @var DiceGraphic $computer instance of the class DiceGraphic, subclass of Dices.
    */
    public function __construct()
    {
        $this->message = null;
        $this->formValue = [];
        $this->player = new DiceGraphic();
        $this->computer = new DiceGraphic();
    }

    /**
    * Rolls a dice for each player and determines who is the starting player (highest roll).
    * On a tie, rolls the dices again until a winner can be detrmined.
    * $p and $c only for testing purposes to be able to manipluate the method.
    * @return void
    */
    public function rollStart($play = 0, $comp = 0)
    {
        do {
            $playerp = $this->player->rollDie() + $play;
            $computerp = $this->computer->rollDie() + $comp;
            $this->message = "Player rolls " . $playerp . " <i class=\"dice-sprite " . $this->player->graphic() . "\"></i><br>Computer rolls " . $computerp . " <i class=\"dice-sprite " . $this->computer->graphic() . "\"></i>";
            if ($playerp < $computerp) {
                $this->message = $this->message . "<br>Computer starts.";
                $this->formValue = [
                    "1" => [
                        "action" => "play_computer_proc",
                        "submit" => "Roll the dice"
                    ]
                ];
                $i = 1;
            } elseif ($playerp > $computerp) {
                $this->message = $this->message . "<br>Player starts.";
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
                $i = 1;
            } else {
                $i = 0;
            }
        } while ($i === 0);
    }

    /**
    * @return string $message flash message to be used in the UI.
    * Contains the values of the last rolled dices and tells which player will start.
    */
    public function getMess()
    {
        return $this->message;
    }

    /**
    * @return array $formValue to be used in the submitbuttons in the UI.
    */
    public function getForm()
    {
        return $this->formValue;
    }

    /**
    * For test purpose rolldie.
    */
    public function rollDiePlayer()
    {
        return $this->player->rollDie();
    }

    /**
    * For test purpose rolldie.
    */
    public function rollDieComputer()
    {
        return $this->player->rollDie();
    }
}
