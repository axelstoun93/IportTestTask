<?php

namespace App\Components\Iport\Api;

use App\Components\Iport\Api\Data\SourceInterface;
use App\Components\Iport\Api\Entity\IportRequest;
use App\Components\Iport\Api\Entity\IportResponse;

/**
 *
 */
class Iport
{

    /**
     * @var SourceInterface
     */
    private SourceInterface $curlClient;

    /**
     * @param SourceInterface $curlClient
     * @return void
     */
    public function setCurlClient(SourceInterface $curlClient) :void {
        $this->curlClient = $curlClient;
    }

    /**
     * @param int $productCode
     * @return IportResponse
     */
    public function getProduct(int $productCode) :IportResponse {
        $request = new IportRequest();
        $request->setUrl('products/'.$productCode);
        $result = $this->curlClient->call([$request]);
        return $result[0];
    }

    /**
     * @param array $productCodes
     * @return array
     */
    public function getProducts(array $productCodes) :array
    {
        $requests = [];

        foreach ($productCodes as $code) {
            $request = new IportRequest();
            $request->setUrl('products/' . $code);
            $requests[] = $request;
        }

        return $this->curlClient->call($requests);
    }

}
