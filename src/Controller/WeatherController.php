<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\WeatherServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Service\Exception\ServiceException;

/**
 * @author Karol Gancarczyk
 */
class WeatherController extends AbstractController {

    private const DEFAULT_PAGE_NUMBER = 1;
    private const ITEMS_PER_PAGE = 10;

    /**
     * @Route("/", name="show_map", methods={"GET"})
     */
    public function showMap() {
        return $this->render('weather/show_map.html.twig');
    }

    /**
     * @Route("/searchHistory", name="search_history", methods={"GET"})
     */
    public function showSearchHistory(WeatherServiceInterface $weatherService, Request $request) {
        try {
            $pageNumber = $request->query->getInt('page', self::DEFAULT_PAGE_NUMBER);
            if ($pageNumber <= 0) {
                $pageNumber = self::DEFAULT_PAGE_NUMBER;
            }

            $weatherObjects = $weatherService->getWeatherSearchHistory($pageNumber, self::ITEMS_PER_PAGE);
            $weatherStats = $weatherService->getWeatherStats();

            return $this->render('weather/search_history.html.twig', [
                'weatherObjects' => $weatherObjects,
                'weatherStats' => $weatherStats,
            ]);
        } catch (ServiceException $e) {
            return $this->render('error.html.twig');
        }
    }
}
