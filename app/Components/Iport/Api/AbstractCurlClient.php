<?php
namespace App\Components\Iport\Api;

use App\Components\Iport\Api\Data\SourceInterface;
use App\Components\Iport\Api\Entity\IportRequest;
use App\Components\Iport\Api\Exception\IportCurlException;

/**
 *
 */
class AbstractCurlClient implements SourceInterface
{

    /**
     * @var IportResponseFactory
     */
    protected IportResponseFactory $iportResponseFactory;

    /**
     * @var
     */
    protected $curl;

    /**
     * @var int
     */
    protected int $timeout = 80;

    /**
     * @var int
     */
    protected int $connectionTimeout = 30;

    /**
     * @var array
     */
    protected array $headers = [];

    /**
     * @var array
     */
    protected array $requestArray = [];

    /**
     * @var array|string[]
     */
    protected array $defaultHeaders = [
        'Content-Type' => 'application/json; charset=utf-8',
        'Accept' => 'application/json',
    ];

    /**
     *
     */
    public function __construct()
    {
        $this->iportResponseFactory = new IportResponseFactory();
    }

    /**
     * @param array $requestArray
     * @return array
     */
    public function call(array $requestArray): array
    {
        $readyResponse = [];

        $this->setRequestArray($requestArray);

        if (count($this->getRequestArray()) == 1) {
            $request = $this->getRequestArray()[0];

            $headers = $this->prepareHeaders($this->getHeader());

            $url = $request->getUrl();

            $this->prepareCurl($request, $this->implodeHeaders($headers), $url);

            list($response, $httpCode) = $this->sendRequest();

            $this->closeCurlConnection();

            $readyResponse[] = $this->iportResponseFactory->create($this->decodeData($response), $httpCode);
        }

        if (count($this->getRequestArray()) > 1) {
            foreach ($this->getRequestArray() as $request) {
                $headers = $this->prepareHeaders($headers);

                $url = $request->getUrl();

                $this->prepareCurl($request, $this->implodeHeaders($headers), $url);

                list($response, $httpCode) = $this->sendRequest();

                $this->closeCurlConnection();

                $readyResponse[] = $this->iportResponseFactory->create($this->decodeData($response), $httpCode);
            }
        }

        return $readyResponse;
    }


    /**
     * @param string $response
     * @return array
     */
    public function decodeData(string $response): array
    {
        if(!empty($response)){

                $result = json_decode($response, true);

                if(!is_array($result)){
                    $this->closeCurlConnection();
                    $api = IportRequest::IPORT_API_URL;
                    throw new IportCurlException("Сейчас слишком много запросов к $api , повторите загрузку файла!");
                }
                return $result;
            }

        return [];
    }


    /**
     * @return array
     * @throws IportCurlException
     */
    protected function sendRequest(): array
    {
        $response = curl_exec($this->curl);
        $responseInfo = curl_getinfo($this->curl);
        $curlError = curl_error($this->curl);
        $curlErrno = curl_errno($this->curl);
        if ($response === false) {
            $this->handleCurlError($curlError, $curlErrno);
        }

        return [$response, $responseInfo['http_code']];
    }

    /**
     * @param array $headers
     * @return array
     */
    protected function prepareHeaders(array $headers): array
    {
        $headers = array_merge($this->defaultHeaders, $headers);
        return $headers;
    }


    /**
     * @param array $headers
     * @return array
     */
    protected function implodeHeaders(array $headers): array
    {
        return array_map(
            function ($key, $value) {
                return $key . ':' . $value;
            },
            array_keys($headers),
            $headers
        );
    }

    /**
     * @param array $header
     * @return void
     */
    protected function setHeader(array $header): void
    {
        $this->headers = $header;
    }

    /**
     * @return array
     */
    protected function getHeader(): array
    {
        return $this->headers;
    }


    /**
     * @param $optionName
     * @param $optionValue
     * @return bool
     */
    protected function setCurlOption($optionName, $optionValue)
    {
        return curl_setopt($this->curl, $optionName, $optionValue);
    }


    /**
     * @return void
     * @throws IportCurlException
     */
    protected function initCurl()
    {
        if (!extension_loaded('curl')) {
            throw new IportCurlException('curl error');
        }

        $this->curl = curl_init();
    }


    /**
     * @return void
     */
    protected function closeCurlConnection(): void
    {
        if ($this->curl !== null) {
            curl_close($this->curl);
        }
    }


    /**
     * @param IportRequest $request
     * @param array $headers
     * @param string $url
     * @return void
     * @throws IportCurlException
     */
    protected function prepareCurl(IportRequest $request, array $headers, string $url): void
    {
        $this->initCurl();

        $this->setParamUrl($url, $request->getParams());

        $this->setCurlOption(CURLOPT_URL, $url);

        $this->setCurlOption(CURLOPT_RETURNTRANSFER, true);

        $this->setCurlOption(CURLOPT_CONNECTTIMEOUT, $this->connectionTimeout);

        $this->setCurlOption(CURLOPT_TIMEOUT, $this->timeout);
    }


    /**
     * @param $url
     * @param array $params
     * @return void
     */
    protected function setParamUrl(&$url, array $params): void
    {
        if (!empty($params)) {
            $url = $url . '?' . http_build_query($params);
        }
    }

    /**
     * @param array $requestArray
     * @return void
     */
    protected  function setRequestArray(array $requestArray)
    {
        $this->requestArray = $requestArray;
    }


    /**
     * @return array
     */
    protected  function getRequestArray()
    {
        return $this->requestArray;
    }


    /**
     * @param $error
     * @param $errno
     * @return void
     * @throws IportCurlException
     */
    protected function handleCurlError($error, $errno): void
    {
        switch ($errno) {
            case CURLE_COULDNT_CONNECT:
            case CURLE_COULDNT_RESOLVE_HOST:
            case CURLE_OPERATION_TIMEOUTED:
                $msg = 'Could not connect to api https://stage.api.iport.ru/api/ Please check your internet connection and try again.';
                break;
            case CURLE_SSL_CACERT:
            case CURLE_SSL_PEER_CERTIFICATE:
                $msg = 'Could not verify SSL certificate.';
                break;
            default:
                $msg = 'Unexpected error communicating.';
        }
        $msg .= "\n\n(Network error [errno $errno]: $error)";
        throw new IportCurlException($msg);
    }


}
