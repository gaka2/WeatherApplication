<?php

namespace App\Service\ExternalApiClient;

use App\Entity\Weather;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\Exception\NoSuchIndexException;

/**
 * @author Karol Gancarczyk
 */
class WeatherExternalApiClientService implements WeatherExternalApiClientServiceInterface {

    private const API_URL = 'http://api.openweathermap.org/data/2.5/weather';
    private const UNITS = 'metric';
    private const LANGUAGE = 'pl';

    private $client;
    private $apiKey;

    public function __construct(HttpClientInterface $client, string $apiKey) {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function getCurrentWeather(float $latitude, float $longitude): Weather {

        $response = $this->client->request('GET', self::API_URL, [
            'query' => [
                'lat' => $latitude,
                'lon' => $longitude,
                'units' => self::UNITS,
                'lang' => self::LANGUAGE,
                'appid' => $this->apiKey,
            ],
        ]);

        $statusCode = $response->getstatusCode();
        if ($statusCode !== Response::HTTP_OK) {
            throw new \RuntimeException('External API returned wrong status code:' . $statusCode);
        }

        $responseContent = $response->getContent();
        $dataFromApi = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
        return $this->mapDataFromApi($dataFromApi);
    }

    private function mapDataFromApi(array $data): Weather {
        try {
            $propertyAccessor = PropertyAccess::createPropertyAccessorBuilder()->enableExceptionOnInvalidIndex()->getPropertyAccessor();

            $weather = new Weather();
            $weather->setCity($propertyAccessor->getValue($data, '[name]'));
            $weather->setLatitude($propertyAccessor->getValue($data, '[coord][lat]'));
            $weather->setLongitude($propertyAccessor->getValue($data, '[coord][lon]'));
            $weather->setTemperature($propertyAccessor->getValue($data, '[main][temp]'));
            $weather->setWind($propertyAccessor->getValue($data, '[wind][speed]'));
            $weather->setClouds($propertyAccessor->getValue($data, '[clouds][all]'));
            $weather->setDescription($propertyAccessor->getValue($data, '[weather][0][description]'));
            $weather->setSearchDateTime(new \DateTime());
            return $weather;
        } catch (NoSuchIndexException $e) {
            throw new \UnexpectedValueException('Invalid data passed to ' . __METHOD__ . ': ' . var_export($data, true));
        }
    }

}
