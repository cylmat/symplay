<?php

declare(strict_types=1);

namespace App\DataBundle\Service\Redis;

use App\AppData\Infrastructure\Redis\RedisClient;
use App\Data\Domain\Redis\RedisScriptsInterface;

/** @see https://app.redislabs.com */
final class RedisScripts implements RedisScriptsInterface
{
    public function __construct(
        private readonly RedisClient $redisClient,
    ) {
    }

    /**
     * @see http://lua-users.org/wiki/MathLibraryTutorial
     * @see https://redis.io/docs/manual/programmability/eval-intro
     * @see https://redis-doc-test.readthedocs.io/en/latest/commands/eval
     */
    public function getRandomInt(): int
    {
        return (int) $this->redisClient->eval('math.randomseed(ARGV[1]); return math.random(0, 100)', 0, time() * rand());
    }
}
