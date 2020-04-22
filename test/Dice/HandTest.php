<?php

namespace Adei18\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Game.
 */
class HandTest extends TestCase
{

    /**
     * Check if roll gives the right number of numbers
     */
    public function testRoll()
    {
        $hand = new Hand();

        $hand->roll();
        $res = $hand->values();
        $exp = 5;
        $this->assertCount($exp, $res);
        $this->assertContainsOnly('int', $res);
    }


    /**
     * Does check for one work
     */
    public function testCheckForOne()
    {
        $hand = new Hand();

        $hand->forseValues([2, 3, 4, 5, 6]);
        $res = $hand->checkForOne();
        $exp = false;
        $this->assertEquals($exp, $res);

        $hand->forseValues([2, 3, 1, 5, 6]);
        $res = $hand->checkForOne();
        $exp = true;
        $this->assertEquals($exp, $res);
    }



    /**
     * Check if sum works
     */
    public function testSum()
    {
        $hand = new Hand();

        $hand->roll();
        $res = $hand->sum();
        $exp = array_sum($hand->values());
        $this->assertEquals($exp, $res);
    }
}
