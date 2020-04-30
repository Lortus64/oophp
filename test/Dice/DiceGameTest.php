<?php

namespace Adei18\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Game.
 */
class GameTest extends TestCase
{
    
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testCreateObject()
    {
        $game = new Game();
        $this->assertInstanceOf("\Adei18\Dice\Game", $game);

        $res = $game->tempPoints();
        $exp = 0;
        $this->assertEquals($exp, $res);

        $res = $game->player();
        $exp = [
            "Player" => 0,
            "Computer" => 0
        ];
        $this->assertEquals($exp, $res);
    }




    /**
     * Test the temppoint system. Update temp and reset.
     */
    public function testPoints()
    {
        $game = new Game();
        $game->hand->roll();
        $game->tempPointsUpdate();


        $res = $game->tempPoints();
        $exp = 5;
        $this->assertGreaterThanOrEqual($exp, $res);

        $exp = 30;
        $this->assertLessThanOrEqual($exp, $res);

        $game->tempPointsReset();
        $res = $game->tempPoints();
        $exp = 0;
        $this->assertEquals($exp, $res);
    }



    /**
     * Test the you can give players points
     */
    public function testGivePoints()
    {
        $game = new Game();
        $game->hand->roll();
        $game->tempPointsUpdate();
        $exp = $game->tempPoints();

        $game->givePoints("Player");
        $res = $game->player();
        $this->assertEquals($exp, $res["Player"]);
    }



    /**
     * Test that the computers logic works
     */
    public function testComputer()
    {
        $game = new Game();
        $expIfOne = 0;
        
        for ($i=0; $i < 8; $i++) { 
            $game->Computer();
            $test = $game->hand->values();

            if (in_array(1, $test)) {
                $res = $game->player();
                $this->assertEquals($expIfOne, $res["Computer"]);
            } else {
                $res = $game->player();

                $exp = 5;
                $this->assertGreaterThanOrEqual($exp, $res["Computer"]);

                $exp = 120;
                $this->assertLessThanOrEqual($exp, $res["Computer"]);
                $expIfOne = $res["Computer"];
            }
        }
    }




    /**
     * Test that the computers logic works with the new 71 rule
     */
    public function testComputerNew()
    {
        $game = new Game();
        $expIfOne = 80;
        
        $game->hand->forseValues([40,40]);
        $game->tempPointsUpdate();
        $game->givePoints("Computer");

        for ($i=0; $i < 8; $i++) { 
            $game->Computer();
            $test = $game->hand->values();

            if (in_array(1, $test)) {
                $res = $game->player();
                $this->assertEquals($expIfOne, $res["Computer"]);
            } else {
                $res = $game->player();

                $exp = 99;
                $this->assertGreaterThanOrEqual($exp, $res["Computer"]);

                $expIfOne = $res["Computer"];
            }
        }
    }




    /**
     * Test the you can give players points
     */
    public function testWinner()
    {
        $game = new Game();

        $res = $game->winner();
        $exp = null;
        $this->assertEquals($exp, $res);

        $game->hand->forseValues([20, 20, 20, 20, 20]);
        $game->tempPointsUpdate();
        $game->givePoints("Player");

        $res = $game->winner();
        $exp = "Player";
        $this->assertEquals($exp, $res);
    }
}
