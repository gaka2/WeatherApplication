<?php

declare(strict_types=1);

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;
use App\Entity\Weather;

/**
 * @author Karol Gancarczyk
 */
class NewWeatherEvent extends Event {

    private Weather $weather;

    public function __construct(Weather $weather) {
        $this->weather = $weather;
    }

    public function getWeather(): Weather {
        return $this->weather;
    }
}
