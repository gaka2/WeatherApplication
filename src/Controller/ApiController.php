<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\WeatherServiceInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Utilities\RequestHelper;
use App\Utilities\Exception\InvalidRequestDataException;
use App\Api\CorrectResponse;
use App\Api\InvalidRequestResponse;
use App\Api\InternalErrorResponse;
use App\Service\Exception\ServiceException;

/**
 * @Route("/api", name="api.")
 * @author Karol Gancarczyk
 */
class ApiController extends AbstractController {

    /**
     * @Route("/getCurrentWeather", name="get_current_weather", methods={"POST"})
     */
    public function getCurrentWeather(Request $request, WeatherServiceInterface $weatherService, SerializerInterface $serializer) {
        try {
            $requestHelper = RequestHelper::createFromRequest($request);
            $latitude = $requestHelper->getPostData('latitude');
            $longitude = $requestHelper->getPostData('longitude');
            $weather = $weatherService->getCurrentWeather($latitude, $longitude);
            return new CorrectResponse($serializer->serialize($weather, 'json'));
        } catch (InvalidRequestDataException $e) {
            return new InvalidRequestResponse($e->getMessage());
        } catch (ServiceException $e) {
            return new InternalErrorResponse();
        }
    }
}
