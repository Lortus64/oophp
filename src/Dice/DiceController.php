<?php

namespace Adei18\Dice;

/**
 * Controller for game
 */
class DiceController
{
    /**
     * @var Game $game   the dice game class.
     */
    private $game;
    private $one;
    private $win;




    /**
     * The initialize method
     * @return void
     */
    public function initialize() : void
    {
        $this->game = new Game();
        $this->one = false;
        $this->win = null;
    }




    /**
     * The initialize method
     */
    public function getWin()
    {
        return $this->win;
    }





        /**
     * The initialize method
     */
    public function getGame()
    {
        return $this->game;
    }




    /**
     * The initialize method
     */
    public function getOne()
    {
        return $this->one;
    }




    /**
     * Reset the game
     * @return void
     */
    public function reset()
    {
        $this->game = new Game();
        $this->one = false;
        $this->win = null;
        $this->game->serie = [];
    }




    /**
     * Roll th dice
     * @return void
     */
    public function roll()
    {
        $this->game->hand->roll();
        $this->game->serie = array_merge($this->game->serie, $this->game->hand->values());
        if ($this->game->hand->checkForOne()) {
            $this->one = true;
            $this->game->tempPointsReset();
        } else {
            $this->game->tempPointsUpdate();
        }
    }




    /**
     * Save the points
     * @return void
     */
    public function save()
    {
        $this->game->givePoints("Player");
        $this->game->tempPointsReset();
        $this->game->computer();
        $this->one = false;
        $this->win = $this->game->winner();
    }




    /**
     * Computers turn
     * @return void
     */
    public function comp()
    {
        $this->game->computer();
        $this->one = false;
        $this->win = $this->game->winner();
    }
}
