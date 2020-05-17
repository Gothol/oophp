<?php

namespace Joel\Dice;

/**
* Trait for showing a historgram
*/

trait HistogramTrait
{
    /**
    * @var array $sequence variabel to store the sequence to be showed in the histogram.
    */
    private $sequence = [];

    /**
    * Get the sequence. Returns an array with the numbers.
    *@return array
    */
    public function getHistogramSequence()
    {
        return $this->sequence;
    }

    /**
    * Get thr minimal value for the histogram.
    * @return int the min value (1).
    */
    public function getHistogramMin()
    {
        return 1;
    }

    /**
    * Get the maximal value for the histogram.
    * @return int the max value.
    */
    public function getHistogramMax()
    {
        //return max($this->sequence);
        return $this->hand->getSidesMax();
    }
}
