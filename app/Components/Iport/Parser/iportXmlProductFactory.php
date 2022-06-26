<?php
namespace App\Components\Iport\Parser;

use App\Components\Iport\Parser\Entity\iportXmlProduct;

/**
 *
 */
class iportXmlProductFactory
{

    /**
     * @var array
     */
    private array $productCodeArray = [];

    /**
     * @param $productArray
     * @return iportXmlProduct
     */
    public function create($productArray) :iportXmlProduct
    {
        $product = new iportXmlProduct();
        $product->setSerialNumber((string)$productArray['СерийныйНомер']);
        $product->setProductCode((int)$productArray['КодТовара']);
        $product->setStock((string)$productArray['Склад']);
        $product->setRegion((string)$productArray['Регион']);
        $product->setPrice((int)$productArray['Цена']);
        $product->setCommentaryEngineer((string)$productArray['КомментарийИнженера']);
        $product->setState((string)$productArray['Состояние']);
        $product->setReasonsForMarkdown((string)$productArray['ПричинаУценкиРазвернуто']);
        $this->setProductCodeArray((int)$productArray['КодТовара']);
        return $product;
    }

    /**
     * @param $code
     * @return void
     */
    private function setProductCodeArray($code) :void
    {
        $this->productCodeArray[] = $code;
    }

    /**
     * @return array
     */
    public function getProductCodeArray(): array
    {
        return array_unique($this->productCodeArray);
    }

}
