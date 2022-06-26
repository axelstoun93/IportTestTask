<?php

namespace App\Components\Iport\Api\Entity;

use App\Components\Iport\Api\Data\RequestInterface;

class IportProduct
{
    public string $title;
    public array $images;
    public float $originalPrice;
    public int $productCode;

    public function getImages(): array
    {
        return $this->images;
    }

    public function getImagesJson(): string
    {
        if (!empty($this->images)) {
            return json_encode(array_values($this->getImages()));
        }
        return '';
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getOriginalPrice(): float
    {
        return $this->originalPrice;
    }

    public function getProductCode(): int
    {
        return $this->productCode;
    }

    public function setProductCode(int $productCode): void
    {
        $this->productCode = $productCode;
    }

    public function setImages(array $images): void
    {
        $this->images = $images;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setOriginalPrice(float $originalPrice): void
    {
        $this->originalPrice = $originalPrice;
    }

}
