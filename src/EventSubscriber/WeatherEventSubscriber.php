<?php

namespace App\EventSubscriber;

use App\Event\NewWeatherEvent;
use App\Service\WeatherServiceInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author Karol Gancarczyk
 */
class WeatherEventSubscriber implements EventSubscriberInterface {

    private $weatherService;

    public function __construct(WeatherServiceInterface $weatherService) {
        $this->weatherService = $weatherService;
    }

    public static function getSubscribedEvents() {
        return [
            NewWeatherEvent::class => 'onNewWeatherEvent',
        ];
    }

    public function onNewWeatherEvent(NewWeatherEvent $event): void {
        $this->weatherService->saveWeather($event->getWeather());
    }
}
