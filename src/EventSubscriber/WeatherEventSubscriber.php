<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Event\NewWeatherEvent;
use App\Service\WeatherServiceInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author Karol Gancarczyk
 */
class WeatherEventSubscriber implements EventSubscriberInterface {

    private WeatherServiceInterface $weatherService;

    public function __construct(WeatherServiceInterface $weatherService) {
        $this->weatherService = $weatherService;
    }

    public static function getSubscribedEvents(): array {
        return [
            NewWeatherEvent::class => 'onNewWeatherEvent',
        ];
    }

    public function onNewWeatherEvent(NewWeatherEvent $event): void {
        $this->weatherService->saveWeather($event->getWeather());
    }
}
