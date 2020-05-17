<?php

namespace Joel\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Histogram.
 */
class HistogramMethodsTest extends TestCase
{
    /**
    * Test injectData
    */
    public function testInjectData()
    {
        $round = new Round();
        $this->assertInstanceOf("\Joel\Dice\Round", $round);
        $histogram = new Histogram();
        $this->assertInstanceOf("\Joel\Dice\Histogram", $histogram);

        $sequence = [];
        $round->rollHand100($sequence);
        $histogram->injectData($round);
        $this->assertObjectHasAttribute("sequence", $histogram);
        $this->assertObjectHasAttribute("min", $histogram);
        $this->assertObjectHasAttribute("max", $histogram);
    }
    /**
    * Test getSequence
    */
    public function testGetSequence()
    {
        $round = new Round();
        $this->assertInstanceOf("\Joel\Dice\Round", $round);
        $histogram = new Histogram();
        $this->assertInstanceOf("\Joel\Dice\Histogram", $histogram);

        $sequence = [];
        $round->rollHand100($sequence);
        $histogram->injectData($round);
        $this->assertObjectHasAttribute("sequence", $histogram);

        $res = $histogram->getSequence();
        $this->assertIsArray($res);
        $this->assertCount(2, $res);
        for ($i = 0; $i < 2; $i++) {
            $this->assertGreaterThanOrEqual(1, $res[$i]);
            $this->assertLessThanOrEqual(6, $res[$i]);
        }
    }
    /**
    * Test getMin
    */
    public function testGetMin()
    {
        $round = new Round();
        $this->assertInstanceOf("\Joel\Dice\Round", $round);
        $histogram = new Histogram();
        $this->assertInstanceOf("\Joel\Dice\Histogram", $histogram);

        $sequence = [];
        $round->rollHand100($sequence);
        $histogram->injectData($round);
        $this->assertObjectHasAttribute("min", $histogram);

        $res = $histogram->getMin();
        $exp = 1;
        $this->assertEquals($res, $exp);
    }
    /**
    * Test getMax
    */
    public function testGetMax()
    {
        $round = new Round();
        $this->assertInstanceOf("\Joel\Dice\Round", $round);
        $histogram = new Histogram();
        $this->assertInstanceOf("\Joel\Dice\Histogram", $histogram);

        $sequence = [];
        $round->rollHand100($sequence);
        $histogram->injectData($round);
        $this->assertObjectHasAttribute("max", $histogram);

        $res = $histogram->getMax();
        $exp = 6;
        $this->assertEquals($res, $exp);
    }

    /**
    * Test getAsText
    */
    public function testGetAsText()
    {
        $round = new Round();
        $this->assertInstanceOf("\Joel\Dice\Round", $round);
        $histogram = new Histogram();
        $this->assertInstanceOf("\Joel\Dice\Histogram", $histogram);

        $sequence = [];
        $round->rollHand100($sequence);
        $histogram->injectData($round);
        $res = $histogram->getAsText();
        $this->assertStringStartsWith("1:", $res);
        $this->assertStringContainsString("*", $res);
    }
}
