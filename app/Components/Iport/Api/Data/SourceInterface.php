<?php

namespace App\Components\Iport\Api\Data;

/**
 * Interface RequestInterface
 */
interface SourceInterface
{
   public function call(array $requestArray) :array;
}
