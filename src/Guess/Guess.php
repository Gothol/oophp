<?php

namespace Joel\Guess;
/**
* Guess my number, a class supporting the game through GET, POST and SESSION.
*/

class Guess
{
    /**
    * @var integer $number   The current secret number.
    * @var integer $tries    Number of tries a guess has been made.
    */
    private $number;
    private $tries;

    /**
    * Constructor to initiate the object with current game settings,
    * if available. Randomize the current number if no value is sent in.
    *
    * @param integer $number The current secret number, default -1 to initiate
    *                    the number from start.
    * @param integer $tries  Number of tries a guess has been made,
    *                    default 6.
    */
    public function __construct(int $number = -1, int $tries = 7)
    {
        $this->number = $number;
        if ($number === -1) {
            $this->random();
        }
        $this->tries = $tries;
    }

    /**
    * Randomize the secret number between 1 and 100 to initiate a new game.
    *
    * @return void
    */
    public function random()
    {
        $this->number = rand(1, 100);
    }



    /**
    * Get number of tries left.
    *
    * @return integer as number of tries made.
    */

    public function tries()
    {
        return $this->tries;
    }




    /**
    * Get the secret number.
    *
    * @return integer as the secret number.
    */

    public function number()
    {
        return $this->number;
    }




    /**
    * Make a guess, decrease remaining guesses and return a string stating
    * if the guess was correct, too low or to high or if no guesses remains.
    *
    * @throws GuessException when guessed number is out of bounds.
    *
    * @return string to show the status of the guess made.
    */

    public function makeGuess($number)
    {
        /**
        * Check that the guess is an integer and between 1 and 100.
        */
        if (!(is_int($number) && ($number >= 1 && $number <= 100))) {
            throw new GuessException("Guess must be between 1 and 100.");
        }

        $this->tries = $this->tries - 1;

        if ($this->tries > 0) {
            if ($number === $this->number) {
                $this->tries = 0;
                return "Your guess " . $number . " is CORRECT!";
            } else if ($number < $this->number) {
                return "Your guess " . $number . " is TO LOW";
            } else {
                return "Your guess " . $number . " is TO HIGH";
            }
        } else {
            return "You are out of guesses.";
        }
    }
}
