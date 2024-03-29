<?php

declare(strict_types=1);

namespace App\Service\ExternalApiClient;

use App\Entity\Weather;

/**
 * @author Karol Gancarczyk
 */
interface WeatherExternalApiClientServiceInterface {

    function getCurrentWeather(float $latitude, float $longitude): Weather;

}
