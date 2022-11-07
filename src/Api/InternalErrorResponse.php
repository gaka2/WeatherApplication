<?php

declare(strict_types=1);

namespace App\Api;

use Symfony\Component\HttpFoundation\Response;

/**
 * @author Karol Gancarczyk
 */
class InternalErrorResponse extends AbstractResponse {

    public function __construct() {
        parent::__construct('error', 'Internal error', '', Response::HTTP_SERVICE_UNAVAILABLE);
    }
}
