<?php

namespace Adei18\Dice;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class Dice
{
    /**
     * @var int $sides   The number of sides.
     * @var int $last    The last roll made.
     */
    private $sides;


    /**
     * Constructor to initiate the object with current game settings,
     * if available.
     *
     * @param int $sides The number of sides on the dice.
     */
    public function __construct(int $sides = 6)
    {
        $this->sides = $sides;
    }



    /**
     * Get sides
     *
     * @return int of sides.
     */
    public function sides()
    {
        return $this->sides;
    }



    /**
    *Randomize last from 1 to sides
     */
    public function roll()
    {
        return $this->last = rand(1, $this->sides);
    }
}
