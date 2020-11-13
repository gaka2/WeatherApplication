<?php

namespace App\DataTransferObject;

/**
 * @author Karol Gancarczyk
 */
class WeatherStats {
    private $temperatureStats;
    private $topCity;
    private $totalNumberOfSearch;

    public function __construct(TemperatureStats $temperatureStats, string $topCity, int $totalNumberOfSearch) {
        $this->temperatureStats = $temperatureStats;
        $this->topCity = $topCity;
        $this->totalNumberOfSearch = $totalNumberOfSearch;
    }

    public function getTemperatureStats(): TemperatureStats {
        return $this->temperatureStats;
    }

    public function getTopCity(): string {
        return $this->topCity;
    }

    public function getTotalNumberOfSearch(): int {
        return $this->totalNumberOfSearch;
    }
}
