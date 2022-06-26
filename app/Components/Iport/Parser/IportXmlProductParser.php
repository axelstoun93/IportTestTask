<?php

namespace App\Components\Iport\Parser;

use App\Components\Iport\Parser\Exception\IportXmlParserProductException;
use XMLReader;

/**
 *
 */
class IportXmlProductParser
{

    /**
     * @var XMLReader
     */
    private XMLReader $xmlReader;

    /**
     * @var iportXmlProductFactory
     */
    private iportXmlProductFactory $productFactory;

    /**
     * @var array
     */
    private array $products = [];

    /**
     * @var array
     */
    private array $productCodes = [];

    /**
     * @param string $uriString
     * @return void
     * @throws IportXmlParserProductException
     */
    public function loadFile(string $uriString): void
    {
        $xmlReader = new XMLReader();
        $this->productFactory = new iportXmlProductFactory();
        try {
            $xmlReader->open($uriString);
        } catch (\Exception $exception) {
            $this->errorHandler($exception);
        }
        $this->xmlReader = $xmlReader;
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        if (empty($this->products)) {
            $this->readFile();
        }

        return $this->products;
    }

    /**
     * @return array
     */
    public function getProductsCode(): array
    {
        if (empty($productCodes)) {
            $this->readFile();
        }
        return $this->productCodes;
    }

    /**
     * @return void
     */
    private function readFile(): void
    {
        while ($this->xmlReader->read()) {
            if ($this->xmlReader->nodeType == XMLReader::ELEMENT && $this->xmlReader->name == 'Товар') {
                $product = simplexml_load_string($this->xmlReader->readOuterXml());
                $this->products[] = $this->productFactory->create((array)$product);
            }
        }
        $this->productCodes = $this->productFactory->getProductCodeArray();
    }


    /**
     * @param $exception
     * @return mixed
     * @throws IportXmlParserProductException
     */
    private function errorHandler($exception)
    {
        $message = $exception->getMessage();
        throw new IportXmlParserProductException("xml file not open: $message");
    }

}
