<?php
namespace Joel\Dice;

/**
 * An interface supporting classes for histogramreports.
 */
interface HistogramInterface
{
    /**
    * Get the sequence with data for the histogram.
    * @return array with the sequence.
    */
    public function getHistogramSequence();

    /**
    * Get the min-value to show.
    * @return int with the minimal value.
    */
    public function getHistogramMin();

    /**
    * Get the max-value to show.
    * @return int with the maximal value.
    */
    public function getHistogramMax();
}
