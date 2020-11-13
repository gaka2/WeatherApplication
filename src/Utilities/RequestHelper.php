<?php

namespace App\Utilities;

use Symfony\Component\HttpFoundation\Request;
use App\Utilities\Exception\InvalidRequestDataException;

/**
 * @author Karol Gancarczyk
 */
class RequestHelper {

    private $request;

    private function __construct(Request $request) {
        $this->request = $request;
    }

    public static function createFromRequest(Request $request) {
        return new static($request);
    }

    public function getPostData(string $key, $defaultValue = null) {
        $value = $this->request->request->get($key, $defaultValue);
        if ($value === null) {
            throw new InvalidRequestDataException('Request body does not contain key: ' . $key);
        }
        return $value;
    }
}
