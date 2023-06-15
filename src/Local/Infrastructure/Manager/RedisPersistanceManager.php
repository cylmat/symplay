<?php

namespace App\Local\Infrastructure\Manager;

use App\AppBundle\Infrastructure\Manager\NoDoctrineEntityManagerInterface;
use App\Local\Domain\RedisClientInterface;
use Doctrine\Persistence\ManagerRegistry;

class RedisPersistanceManager implements NoDoctrineEntityManagerInterface
{
    public function __construct(
        private readonly RedisClientInterface $redisClient,
        private readonly ManagerRegistry $doctrineRegistry
    ) {
    }

    public function getClient(): RedisClientInterface
    {
        return $this->redisClient;
    }

    public function persist(object $object): void
    {
        $this->redisClient->set(
            $this->definedId($object),
            \serialize($object)
        );
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
