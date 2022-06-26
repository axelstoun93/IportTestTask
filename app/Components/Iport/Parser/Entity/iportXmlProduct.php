<?php

namespace App\Components\Iport\Parser\Entity;

/**
 *
 */
class iportXmlProduct
{

    /**
     * @var string
     */
    public string $serialNumber;
    /**
     * @var int
     */
    public int $productCode;
    /**
     * @var string
     */
    public string $stock;
    /**
     * @var string
     */
    public string $region;
    /**
     * @var string
     */
    public string $price;
    /**
     * @var string
     */
    public string $commentaryEngineer;
    /**
     * @var string
     */
    public string $state;
    /**
     * @var string
     */
    public string $reasonsForMarkdown;

    /**
     * @return int
     */
    public function getProductCode(): int
    {
        return $this->productCode;
    }

    /**
     * @return string
     */
    public function getSerialNumber(): string
    {
        return $this->serialNumber;
    }

    /**
     * @return string
     */
    public function getStock(): string
    {
        return $this->stock;
    }

    /**
     * @return string
     */
    public function getRegion(): string
    {
        return $this->region;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getCommentaryEngineer(): string
    {
        return $this->commentaryEngineer;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getReasonsForMarkdown(): string
    {
        return $this->reasonsForMarkdown;
    }


    /**
     * @param int $productCode
     * @return void
     */
    public function setProductCode(int $productCode): void
    {
        $this->productCode = $productCode;
    }

    /**
     * @param string $serialNumber
     * @return void
     */
    public function setSerialNumber(string $serialNumber): void
    {
        $this->serialNumber = $serialNumber;
    }

    /**
     * @param string $stock
     * @return void
     */
    public function setStock(string $stock): void
    {
        $this->stock = $stock;
    }

    /**
     * @param string $region
     * @return void
     */
    public function setRegion(string $region): void
    {
        $this->region = $region;
    }

    /**
     * @param int $price
     * @return void
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /**
     * @param string $commentaryEngineer
     * @return void
     */
    public function setCommentaryEngineer(string $commentaryEngineer): void
    {
        $this->commentaryEngineer = $commentaryEngineer;
    }

    /**
     * @param string $state
     * @return void
     */
    public function setState(string $state): void
    {
        $this->state = $state;
    }

    /**
     * @param string $reasonsForMarkdown
     * @return void
     */
    public function setReasonsForMarkdown(string $reasonsForMarkdown)
    {
        $this->reasonsForMarkdown = $reasonsForMarkdown;
    }


}
