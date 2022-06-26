<?php

namespace Tests\Unit;

use App\Components\Iport\Parser\IportXmlProductParser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetProducts()
    {
       $file = __DIR__.'/files/TradeIn_markdown.xml';
       $xmlParser = new IportXmlProductParser();
       $xmlParser->loadFile($file);
       $parse = $xmlParser->getProducts();
       $this->assertIsArray($parse);
    }
}
