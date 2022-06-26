<?php

namespace App\Components\Iport\Api;

use App\Components\Iport\Api\Entity\IportRequest;
use App\Components\Iport\Api\Entity\IportResponse;
use App\Components\Iport\Api\Exception\IportCurlException;

/**
 *
 */
class IportCurlClient extends AbstractCurlClient
{
    /**
     * @param IportRequest $request
     * @param array $headers
     * @return mixed
     */
    public function getCurl(IportRequest $request, array $headers = [])
    {
        $headers = $this->prepareHeaders($headers);

        $url = $request->getUrl();

        $this->prepareCurl($request, $this->implodeHeaders($headers), $url);

        return $this->curl;
    }
}
