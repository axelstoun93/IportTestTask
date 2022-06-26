<?php
namespace Tests\Unit;

use App\Components\Iport\Api\Entity\IportResponse;
use App\Components\Iport\Api\Iport;
use App\Components\Iport\Api\IportCurlClient;
use App\Components\Iport\Api\IportMultiCurl;
use PHPUnit\Framework\TestCase;

class IportApiTest extends TestCase
{

    public function testProductApi()
    {
        $curl = new IportCurlClient();
        $iport = new Iport();
        $iport->setCurlClient($curl);
        $result = $iport->getProduct(104210);
        $this->assertInstanceOf(IportResponse::class,  $result);
    }

    public function testProductsApi()
    {
        $testArray = [104210,81885,86104,81868,110652,106133,99117,81882,106159,96909];
        $curl = new IportMultiCurl();
        $iport = new Iport();
        $iport->setCurlClient($curl);
        $result = $iport->getProducts($testArray);
        $this->assertIsArray($result);
    }

}
