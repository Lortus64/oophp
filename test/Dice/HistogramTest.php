<?php

namespace Adei18\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for HistogramTrait.
 */
class HistogramTraitTest extends TestCase
{
    
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testGetHistogramSerie()
    {
        $game = new Game();

        $game->serie = [5, 4, 6];
        $exp = [5, 4, 6];
        $res = $game->getHistogramSerie();
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testGetHistogramMinMax()
    {
        $game = new Game();

        $exp = 1;
        $res = $game->getHistogramMin();
        $this->assertEquals($exp, $res);

        $exp = 6;
        $res = $game->getHistogramMax();
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testGetAsText()
    {
        $game = new Game();

        $game->serie = [5, 4, 6, 1, 1, 3, 1, 4, 2, 3];

        $exp = "1: 3 | 2: 1 | 3: 2 | 4: 2 | 5: 1 | 6: 1 | ";
        $res = $game->getAsText();
        $this->assertEquals($exp, $res);
    }
}
