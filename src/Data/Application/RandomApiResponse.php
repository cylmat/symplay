<?php

declare(strict_types=1);

namespace App\Data\Application;

use App\AppBundle\Application\Common\Api\ApiResponse;
use App\AppBundle\Application\Common\Api\ApiResponseInterface;
use App\Data\Domain\Model\RandomApi;

final class RandomApiResponse extends ApiResponse implements ApiResponseInterface
{
    public function __construct(
        public readonly RandomApi $data,
    ) {
    }
}
