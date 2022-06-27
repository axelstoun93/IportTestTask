<?php
namespace App\Components\Iport\Api;

use App\Components\Iport\Api\Entity\IportRequest;
use App\Components\Iport\Api\Exception\IportCurlException;

/**
 *
 */
class IportMultiCurl extends AbstractCurlClient
{

    /**
     * @var IportCurlClient
     */
    private IportCurlClient $curlClient;

    /**
     * @var
     */
    private $multiCurl;

    /**
     *
     */
    public function __construct()
     {
         parent::__construct();
         $this->curlClient = new IportCurlClient();
     }

    /**
     * @param array $requestArray
     * @param array $headers
     * @return array
     * @throws IportCurlException
     */
    public function call(array $requestArray, array $headers = []): array
    {
        $requestArrayChunk = array_chunk($requestArray, 200);

        $readyResponse = [];

        foreach ($requestArrayChunk as $array) {

            $this->initCurl();

            $this->setRequestArray($array);

            $response = $this->sendRequest();

            $this->closeCurlConnection();

            $readyResponse = array_merge($readyResponse, $response);

        }

        return $readyResponse;
    }

    /**
     * @return array
     * @throws IportCurlException
     */
    public function sendRequest(): array
    {
        $curlsArray = [];

        foreach ($this->getRequestArray() as $request) {
            $curl = $this->curlClient->getCurl($request);
            curl_multi_add_handle($this->multiCurl, $curl);
            $curlsArray[] = $curl;
        }

        do {
            $status = curl_multi_exec($this->multiCurl, $active);
            if ($active) {
                curl_multi_select($this->multiCurl);
            }
        } while ($active && $status == CURLM_OK);

        if ($status != CURLM_OK) {
            $curlErrno = curl_multi_errno($this->multiCurl);
            $curlError = curl_multi_strerror($curlErrno);
            $this->handleCurlError($curlError, $curlErrno);
        }

        $response = [];

        foreach ($curlsArray as $curl) {

            $responseInfo = curl_getinfo($curl);
            $responseContent = curl_multi_getcontent($curl);
            curl_multi_remove_handle($this->multiCurl,$curl);
            curl_close($curl);

            $response[] = $this->iportResponseFactory->create(
                $this->decodeData($responseContent),
                $responseInfo['http_code']
            );


        }

        return $response;
    }


    /**
     * @return void
     * @throws IportCurlException
     */
    protected function initCurl() :void
    {
        if (!extension_loaded('curl')) {
            throw new IportCurlException('curl error');
        }

        $this->multiCurl = curl_multi_init();
    }


    /**
     * @return void
     */
    protected function closeCurlConnection(): void
    {
        if ($this->multiCurl !== null) {
            curl_multi_close($this->multiCurl);
        }
    }

}



