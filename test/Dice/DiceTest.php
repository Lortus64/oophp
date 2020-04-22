<?php

namespace Adei18\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Game.
 */
class DiceTest extends TestCase
{
    
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Adei18\Dice\Dice", $dice);

        $res = $dice->sides();
        $exp = 6;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testCreateObjectFirstArgument()
    {
        $dice = new Dice(20);
        $this->assertInstanceOf("\Adei18\Dice\Dice", $dice);

        $res = $dice->sides();
        $exp = 20;
        $this->assertEquals($exp, $res);
    }
}
