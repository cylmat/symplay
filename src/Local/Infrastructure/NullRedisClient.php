<?php

declare(strict_types=1);

namespace App\Local\Infrastructure;

final class NullRedisClient implements RedisClientInterface
{
    /** @phpstan-ignore-next-line: no return type */
    public function __call(string $name, mixed $arguments)
    {
    }
}
