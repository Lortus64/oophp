<?php

namespace Adei18\Dice;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class Hand
{
    /**
     * @var Dice $dices   Array consisting of dices.
     * @var int  $values  Array consisting of last roll of the dices.
     */
    private $dices;
    private $values;

   /**
    * Constructor to initiate the dicehand with a number of dices.
    *
    * @param int $dices Number of dices to create, defaults to five.
    */
    public function __construct(int $dices = 5)
    {
        $this->dices  = [];
        $this->values = [];

        for ($i = 0; $i < $dices; $i++) {
            $this->dices[]  = new Dice();
        }
    }



    /**
     * Get values of dices from last roll.
     *
     * @return array with values of the last roll.
     */
    public function values()
    {
        return $this->values;
    }



    /**
     * Forse  values fro testing
     */
    public function forseValues($val)
    {
        $this->values = $val;
    }



    /**
     * Roll all dices save their value.
     *
     * @return void.
     */
    public function roll()
    {
        $this->values = [];
        foreach ($this->dices as $key => $dice) {
            $this->values[] = $dice->roll();
        }
    }


    /**
     * Check if there is a 1 and return true if there is one
     *
     * @return void.
     */
    public function checkForOne()
    {
        foreach ($this->values as $key => $value) {
            if ($value == 1) {
                return true;
            }
        }
        return false;
    }



    /**
     * Get the sum of all dices.
     *
     * @return int as the sum of all dices.
     */
    public function sum()
    {
        return array_sum($this->values);
    }
}
