<?php

namespace Tests\Unit;

use App\Components\Iport\Api\Iport;
use App\Components\Iport\Api\IportMultiCurl;
use App\Components\Iport\Parser\IportXmlProductParser;
use App\Models\Product;
use App\Service\LoadProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoadServiceProductTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUpdate()
    {
        $file = __DIR__.'/files/TradeIn_markdown_test.xml';
        $xmlParser = new IportXmlProductParser();
        $xmlParser->loadFile($file);

        $productModelMock = $this->getMockBuilder(Product::class)->getMock();

        $iport = new Iport();
        $iport->setCurlClient(new IportMultiCurl());


        $service = new LoadProductService();

        $result = $service->update($iport, $xmlParser,$productModelMock);

        $this->assertIsArray($result);
    }


    public function testUpdateFull()
    {
        $file = __DIR__.'/files/TradeIn_markdown.xml';
        $xmlParser = new IportXmlProductParser();
        $xmlParser->loadFile($file);

        $productModelMock = $this->getMockBuilder(Product::class)->getMock();

        $iport = new Iport();
        $iport->setCurlClient(new IportMultiCurl());


        $service = new LoadProductService();

        $result = $service->update($iport, $xmlParser,$productModelMock);

        $this->assertIsArray($result);
    }
}
