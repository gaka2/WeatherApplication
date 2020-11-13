<?php

namespace App\Api;

use Symfony\Component\HttpFoundation\Response;

/**
 * @author Karol Gancarczyk
 */
class CorrectResponse extends AbstractResponse {

    public function __construct(string $jsonData) {
        parent::__construct('ok', '', $jsonData, Response::HTTP_OK);
    }
}
