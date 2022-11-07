<?php

declare(strict_types=1);

namespace App\Api;

use Symfony\Component\HttpFoundation\Response;

/**
 * @author Karol Gancarczyk
 */
class InvalidRequestResponse extends AbstractResponse {

    public function __construct(string $message) {
        parent::__construct('error', $message, '', Response::HTTP_BAD_REQUEST);
    }
}
