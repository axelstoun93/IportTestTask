<?php
namespace App\Components\Iport\Api\Entity;

use App\Components\Iport\Api\Data\ResponseInterface;

class IportResponse implements ResponseInterface {

    const ERROR_STATUS = 'error';
    const SUCCESS_STATUS = 'success';

    private int $httpCode;

    public array $data = [];

    public string $status = '';

    public array $errors = [];

    public function __construct(array $response, int $httpCode)
    {
        $this->setHttpCode($httpCode);
        $this->setProperty($response);
    }

    public function setProperty(array $response)
    {
        $arrayObjectProperty = get_object_vars($this);

        foreach ($arrayObjectProperty as $key => $property) {
            if (!empty($response[$key])) {
                $this->$key = $response[$key];
            }
        }
    }

    public function isErrorResponse(): bool
    {
        return $this->httpCode !== 200;
    }

    public function isErrorStatus(): bool
    {
        return $this->status === self::ERROR_STATUS;
    }

    public function setHttpCode(int $httpCode): void
    {
        $this->httpCode = $httpCode;
    }

    public function getResponse(): array
    {
        return $this->data;
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    public function getErrorMessage(): string
    {
        if (!empty($this->errors)) {
            return (string)$this->errors[0]['message'];
        }
        return '';
    }
}
