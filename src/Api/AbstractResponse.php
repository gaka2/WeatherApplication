<?php

declare(strict_types=1);

namespace App\Api;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @author Karol Gancarczyk
 */
abstract class AbstractResponse extends JsonResponse {

    public function __construct(string $status, string $message, string $jsonData, int $httpStatusCode) {
        $responseContent = $this->createResponseContent($status, $message, $jsonData);
        parent::__construct($responseContent, $httpStatusCode);
    }

    private function createResponseContent(string $status, string $message, string $jsonData): array {
        return [
            'status' => $status,
            'message' => $message,
            'data' => json_decode($jsonData, true),
        ];
    }
}
