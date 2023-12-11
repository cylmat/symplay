<?php

declare(strict_types=1);

namespace App\Data\Domain\Model;

use App\AppBundle\Application\Common\Api\ApiResponseInterface;

final class RandomApi implements ApiResponseInterface
{
    public int $random_int;
    public int $random_script_int;
    public string $cache_get;
    public string $cache_dynamic;
}
