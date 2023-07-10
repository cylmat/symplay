<?php

namespace App\Local\Domain;

use Predis\ClientInterface;

/**
 * @method del(array|string $keyOrKeys, ...$keys): int;
 * @method keys(string $pattern): array;
 * @method set(string $key, $value, $expireResolution = null, $expireTTL = null, $flag = null): Status;
 */
interface RedisClientInterface
{
}