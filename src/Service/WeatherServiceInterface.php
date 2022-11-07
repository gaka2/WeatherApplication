<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Weather;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPaginationInterface;
use App\DataTransferObject\WeatherStats;

/**
 * @author Karol Gancarczyk
 */
interface WeatherServiceInterface {
    function getCurrentWeather(float $latitude, float $longitude): Weather;
    function getWeatherSearchHistory(int $pageNumber, int $perPage): SlidingPaginationInterface;
    function getWeatherStats(): WeatherStats;
    function saveWeather(Weather $weather): bool;
}
