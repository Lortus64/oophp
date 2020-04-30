<?php

namespace Adei18\Dice;

/**
 * A trait implementing HistogramInterface.
 */
trait HistogramTrait
{
    /**
     * @var array $serie  The numbers stored in sequence.
     * @var int   $min    The lowest possible number.
     * @var int   $max    The highest possible number.
     */
    public $serie = [];
    private $min = 1;
    private $max = 6;





    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getHistogramSerie()
    {
        return $this->serie;
    }



    /**
     * Get min value for the histogram.
     *
     * @return int with the min value.
     */
    public function getHistogramMin()
    {
        return 1;
    }



    /**
     * Get max value for the histogram.
     *
     * @return int with the max value.
     */
    public function getHistogramMax()
    {
        return 6;
    }



    /**
     * Return a string with a textual representation of the histogram.
     *
     * @return string representing the histogram.
     */
    public function getAsText()
    {
        $number = [
            "1" => 0,
            "2" => 0,
            "3" => 0,
            "4" => 0,
            "5" => 0,
            "6" => 0,
        ];

        $str = "";

        foreach ($this->serie as $key => $value) {
            if ($value == 1) {
                $number["1"] = $number["1"] + 1;
            } elseif ($value == 2) {
                $number["2"] = $number["2"] + 1;
            } elseif ($value == 3) {
                $number["3"] = $number["3"] + 1;
            } elseif ($value == 4) {
                $number["4"] = $number["4"] + 1;
            } elseif ($value == 5) {
                $number["5"] = $number["5"] + 1;
            } else {
                $number["6"] = $number["6"] + 1;
            }
        }

        foreach ($number as $key => $value) {
            if ($this->min || $this->max) {
                if ($key >= $this->min && $key <= $this->max) {
                    $str = $str . ($key . ": " . $value . " | ");
                }
            }
        }
        return $str;
    }
}
