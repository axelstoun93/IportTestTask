<?php
namespace App\Components\Iport\Api\Entity;

use App\Components\Iport\Api\Data\RequestInterface;

class IportRequest implements RequestInterface
{

    CONST IPORT_API_URL = 'https://stage.api.iport.ru/api/';

    private string $url;

    /**
     * @var array
     */
    public array $params = [];

    /**
     * @param array $params
     */
    public function setParams(array $params): void
    {
        $readyParams = [];

        foreach ($params as $key => $value) {
            if (is_null($value)) {
                continue;
            }
            $readyParams[$key] = $value;
        }

        $this->params = $readyParams;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }


    public function setUrl(string $url){
        $this->url = self::IPORT_API_URL.$url;
    }

    public function getUrl(){
        return $this->url;
    }
}
