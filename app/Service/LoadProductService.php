<?php

namespace App\Service;

use App\Components\Iport\Api\Entity\IportProduct;
use App\Components\Iport\Api\Entity\IportResponse;
use App\Components\Iport\Api\Iport;
use App\Components\Iport\Api\IportProductFactory;
use App\Components\Iport\Parser\Entity\iportXmlProduct;
use App\Components\Iport\Parser\IportXmlProductParser;
use App\Models\Product;

class LoadProductService
{
    private int $loadProduct = 0;

    public function update(Iport $apiIport, IportXmlProductParser $xmlParser, Product $modelProduct): array
    {
        $xmlProducts = $xmlParser->getProducts();

        $apiProductsArray = $this->prepareApiProductsArray($xmlParser->getProductsCode(), $apiIport);

        $productModelsArray = [];

        /**
         * @var iportXmlProduct $product
         * @var IportProduct $apiProduct
         */
        foreach ($xmlProducts as $product) {
            $productModel = clone $modelProduct;
            $productModel->name = $product->getProductCode();
            $productModel->product_code = $product->getProductCode();
            $productModel->price = $product->getPrice();
            $productModel->original_price = 0;
            $productModel->active = $modelProduct::ACTIVE_OFF;
            $productModel->state = $product->getState();
            $productModel->stock = $product->getStock();
            $productModel->serial_number = $product->getSerialNumber();
            $productModel->images = null;

            $isFindProductApi = array_key_exists($product->getProductCode(), $apiProductsArray);

            if ($isFindProductApi) {
                $apiProduct = $apiProductsArray[$product->getProductCode()];
                $productModel->images = $apiProduct->getImagesJson();
                $productModel->original_price = $apiProduct->getOriginalPrice();
                $productModel->name = $apiProduct->getTitle();
                $productModel->active = $modelProduct::ACTIVE_ON;
            }
            $productModelsArray[] = $productModel->toArray();
        }

        $chunkModelsArray = array_chunk($productModelsArray, 200);

        foreach ($chunkModelsArray as $chunk) {
            $modelProduct->upsert(
                $chunk,
                ['serial_number'],
                ['name', 'price', 'state', 'stock', 'images', 'original_price', 'active']
            );
        }

        $this->setCountProduct(count($xmlProducts));

        return array_keys($apiProductsArray);
    }

    public function getCountProduct(): int
    {
        return $this->loadProduct;
    }

    public function setCountProduct(int $productCount): void
    {
        $this->loadProduct = $productCount;
    }

    public function deactiveProductNotXmlFile(array $productCodeArray, Product $modelProduct): int
    {
        $result = $modelProduct->whereNotIn('product_code', $productCodeArray)->update(
            ['active' => $modelProduct::ACTIVE_OFF]
        );

        return $result;
    }


    private function prepareApiProductsArray($productCodeArray, Iport $apiIport): array
    {
        $getApiProducts = $apiIport->getProducts($productCodeArray);

        $iportProductFactory = new IportProductFactory();

        $prepareApiProducts = [];

        /**
         * @var IportResponse $apiProduct
         */
        foreach ($getApiProducts as $apiProduct) {
            if ($apiProduct->isErrorStatus()) {
                continue;
            }
            $apiProductData = $apiProduct->getResponse();
            $prepareApiProducts[$apiProductData['KOD']] = $iportProductFactory->create($apiProductData);
        }

        return $prepareApiProducts;
    }

}
