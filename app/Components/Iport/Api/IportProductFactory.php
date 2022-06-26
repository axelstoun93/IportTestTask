<?php
namespace App\Components\Iport\Api;

use App\Components\Iport\Api\Entity\IportProduct;


/**
 *
 */
class IportProductFactory
{

    /**
     * @param array $responseData
     * @return IportProduct
     */
    public function create(array $responseData) :IportProduct
    {
        $product = new IportProduct();
        $product->setProductCode($responseData['KOD']);
        $product->setTitle($responseData['TITLE']);
        $product->setImages($responseData['IMAGES']);
        $product->setOriginalPrice($responseData['PRICE']['VALUE']);
        return $product;
    }

}
