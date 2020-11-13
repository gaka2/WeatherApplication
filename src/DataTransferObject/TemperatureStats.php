<?php

namespace App\DataTransferObject;

/**
 * @author Karol Gancarczyk
 */
class TemperatureStats {
    private $min;
    private $max;
    private $average;

    public function __construct(float $min, float $max, float $average) {
        $this->min = $min;
        $this->max = $max;
        $this->average = round($average, 2);
    }

    public function getMin(): float {
        return $this->min;
    }

    public function getMax(): float {
        return $this->max;
    }

    public function getAverage(): float {
        return $this->average;
    }
}
