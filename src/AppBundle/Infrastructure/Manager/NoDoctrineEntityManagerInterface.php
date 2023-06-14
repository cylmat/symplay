<?php

namespace App\AppBundle\Infrastructure\Manager;

interface NoDoctrineEntityManagerInterface
{
    public function persist(object $object): void;

    public function flushall(string $tableName): void;
}
