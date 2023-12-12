<?php

declare(strict_types=1);

namespace App\Data\Infrastructure\Manager;

use App\AppBundle\Infrastructure\AppEntityManagerInterface;
use App\Data\Infrastructure\Redis\RedisClientInterface;
use Doctrine\Persistence\ManagerRegistry;

final class RedisEntityManager implements AppEntityManagerInterface
{
    public function __construct(
        private readonly RedisClientInterface $redisClient,
        private readonly ManagerRegistry $doctrineRegistry,
    ) {
    }

    public function getClient(): RedisClientInterface
    {
        return $this->redisClient;
    }

    public function persist(object $object): void
    {
        $this->redisClient->set($this->definedId($object), \serialize($object));
    }

    public function flush(): void
    {
        // nothing to do for redis ...
    }

    public function remove(object $object): void
    {
        $this->redisClient->del($this->definedId($object));
    }

    private function definedId(object $object): string
    {
        $tableName = $this->doctrineRegistry
            ->getManagerForClass($object::class)
            ->getClassMetadata($object::class)->getTableName();

        return $tableName.':'.$object->getId();
    }
}
