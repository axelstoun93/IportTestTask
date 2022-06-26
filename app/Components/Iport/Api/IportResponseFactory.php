<?php
namespace App\Components\Iport\Api;

use App\Components\Iport\Api\Entity\IportResponse;

/**
 * Class OpenExchangeResponseFactory
 */
class IportResponseFactory
{

    public function create(array $response, int $httpCode) :IportResponse
    {
        return new IportResponse($response, $httpCode);
    }

}
