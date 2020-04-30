<?php

namespace Adei18\Dice;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class Game implements HistogramInterface
{


    use HistogramTrait;



    /**
     * @var Hand $hand   the hand class.
     * @var int  $tempPoints  temporary points
     * @var int  $player  Array consisting of players points.
     */
    public $hand;
    private $tempPoints;
    private $player;

   /**
    * Constructor to initiate the dicehand with a number of dices.
    *
    * @param int $dices Number of dices to create, defaults to five.
    */
    public function __construct()
    {
        $this->hand  = new Hand;
        $this->tempPoints = 0;
        $this->player = [
        "Player" => 0,
        "Computer" => 0,
        ];
    }



    /**
     * Get values tempPoints.
     *
     * @return int with values of tempPoints.
     */
    public function tempPoints()
    {
        return $this->tempPoints;
    }


    /**
     * Set values tempPoints.
     *
     */
    public function tempPointsUpdate()
    {
            $this->tempPoints = $this->tempPoints + $this->hand->sum();
    }



    /**
     * Set values tempPoints to 0.
     *
     */
    public function tempPointsReset()
    {
        $this->tempPoints = 0;
    }



    /**
     * Get values player.
     *
     * @return array with values of player.
     */
    public function player()
    {
        return $this->player;
    }



    /**
     * Give active player points
     */
    public function givePoints($player)
    {

        $this->player[$player] = $this->player[$player] + $this->tempPoints;
        $this->resetPoints();
    }



    /**
     * Reset temp points
     */
    public function resetPoints()
    {
        $this->tempPoints = 0;
    }



    /**
     * Computer logic
     */
    public function computer()
    {
        if ($this->player["Player"] > 71 || $this->player["Computer"] > 71) {
            while ($this->tempPoints + $this->tempPoints() < 100) {
                $this->hand->roll();
                $this->serie = array_merge($this->serie, $this->hand->values());
                if ($this->hand->checkForOne()) {
                    $this->tempPointsReset();
                    break 1;
                }
                $this->tempPointsUpdate();
            }
        } else {
            while ($this->tempPoints < 20) {
                $this->hand->roll();
                $this->serie = array_merge($this->serie, $this->hand->values());
                if ($this->hand->checkForOne()) {
                    $this->tempPointsReset();
                    break 1;
                }
                $this->tempPointsUpdate();
            }
        }
        
        $this->givePoints("Computer");
        $this->tempPointsReset();
    }



    /**
     * Check winner
     *
     * @return string with values of tempPoints.
     */
    public function winner()
    {
        foreach ($this->player as $key => $value) {
            if ($value >= 100) {
                return $key;
            }
        }
        return null;
    }
}
