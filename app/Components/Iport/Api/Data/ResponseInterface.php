<?php
namespace App\Components\Iport\Api\Data;

/**
 * Interface ResponseInterface
 */
interface ResponseInterface
{

    /**
     * @return bool
     */
    public function isErrorResponse(): bool;

    /**
     * @return array
     */
    public function getResponse(): array;

    /**
     * @return int
     */
    public function getHttpCode(): int;

    /**
     * @param int $httpCode
     */
    public function setHttpCode(int $httpCode): void;

    /**
     * @return string
     */
    public function getErrorMessage(): string;

}
