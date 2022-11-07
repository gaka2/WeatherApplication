<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Weather;
use App\Service\ExternalApiClient\WeatherExternalApiClientServiceInterface;
use Psr\Log\LoggerInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\WeatherRepository;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPaginationInterface;
use App\DataTransferObject\WeatherStats;
use App\DataTransferObject\TemperatureStats;
use Doctrine\DBAL\DBALException;
use App\Service\Exception\ServiceException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Event\NewWeatherEvent;

/**
 * @author Karol Gancarczyk
 */
class WeatherService implements WeatherServiceInterface {

    private WeatherExternalApiClientServiceInterface $weatherApiClient;
    private LoggerInterface $logger;
    private PaginatorInterface $paginator;
    private WeatherRepository $weatherRepository;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(WeatherExternalApiClientServiceInterface $weatherApiClient, LoggerInterface $logger, PaginatorInterface $paginator, WeatherRepository $weatherRepository, EventDispatcherInterface $eventDispatcher) {
        $this->weatherApiClient = $weatherApiClient;
        $this->logger = $logger;
        $this->paginator = $paginator;
        $this->weatherRepository = $weatherRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function getCurrentWeather(float $latitude, float $longitude): Weather {
        try {
            $weather = $this->weatherApiClient->getCurrentWeather($latitude, $longitude);
            $this->notifyCurrentWeatherFetched($weather);
            return $weather;
        } catch (\RuntimeException $e) {
            $this->logger->error($e->getMessage());
            $this->logger->error($e->getTraceAsString());
            throw new ServiceException();
        }
    }

    private function notifyCurrentWeatherFetched(Weather $weather): void {
        $event = new NewWeatherEvent($weather);
        $this->eventDispatcher->dispatch($event);
    }

    public function saveWeather(Weather $weather): bool {
        try {
            $this->weatherRepository->save($weather);
            return true;
        } catch (DBALException $e) {
            $this->logger->error($e->getMessage());
            $this->logger->error($e->getTraceAsString());
            return false;
        }
    }

    public function getWeatherSearchHistory(int $pageNumber, int $perPage): SlidingPaginationInterface {
        try {
            $query = $this->weatherRepository->findAllOrderedByIdQuery();
            $weatherObjects = $this->paginator->paginate(
                $query,
                $pageNumber,
                $perPage
            );

            return $weatherObjects;
        } catch (DBALException $e) {
            $this->logger->error($e->getMessage());
            $this->logger->error($e->getTraceAsString());
            throw new ServiceException();
        }
    }

    public function getWeatherStats(): WeatherStats {
        try {
            $result = $this->weatherRepository->getTemperatureStats();
            $temperatureStats = new TemperatureStats((float) $result['min'], (float) $result['max'], (float) $result['avg']);
            $topCity = $this->weatherRepository->getTopCity();
            $totalNumberOfSearch = $this->weatherRepository->getTotalNumberOfSearch();
            $weatherStats = new WeatherStats($temperatureStats, $topCity, $totalNumberOfSearch);
            return $weatherStats;
        } catch (DBALException $e) {
            $this->logger->error($e->getMessage());
            $this->logger->error($e->getTraceAsString());
            throw new ServiceException();
        }
    }
}
