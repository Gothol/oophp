<?php

namespace Joel\Dice;

/**
* Class for generating historgram data
*/

class Histogram
{
    /**
    * @var array $sequence variabel to store the sequence to be showed in the histogram.
    * @var int $min the lowest value to show in the histogram.
    * @var int $max the highest value to show in the histogram.
    */
    private $sequence = [];
    private $min;
    private $max;

    /**
    * Inject the object to use a base for the histogram.
    * @param HistogramInterface $object the object holding the sequence.
    * @return void.
    */
    public function injectData(HistogramInterface $object)
    {
        $this->sequence = $object->getHistogramSequence();
        $this->min = $object->getHistogramMin();
        $this->max = $object->getHistogramMax();
    }
    /**
    * Get the sequence. Returns an array with the numbers.
    *@return array
    */
    public function getSequence()
    {
        return $this->sequence;
    }

    public function getMin()
    {
        return $this->min;
    }

    public function getMax()
    {
        return $this->max;
    }

    /**
    * Print the histogram. Default is to print only the values which has a result. Default
    * is when neither min nor max is set.
    * @param int min Minimum value in the sequence to show.
    * @param int max Maximum value in the sequence to show.
    * @return string $histogram. The histogram as a string with html-tags to be showed at a webpage.
    */
    public function getAsText()
    {
        $histogram = "";
        $serie = array_count_values($this->sequence);
        for ($i = $this->min; $i <= $this->max; $i++) {
            if (!(array_key_exists($i, $serie))) {
                $serie[$i] = 0;
            }
        }
        ksort($serie);
        foreach ($serie as $key => $value) {
            $histogram = $histogram . $key . ":";
            for ($i = 0; $i < $value; $i++) {
                $histogram = $histogram . "*";
            }
            $histogram = $histogram . "<br>";
        }

        return $histogram;
    }
}
