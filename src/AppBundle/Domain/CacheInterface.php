<?php

namespace App\AppBundle\Domain; /** @todo use "contracts" directory */

interface CacheInterface
{
    public function get(string $key, callable $callback, float $beta = null, array &$metadata = null): mixed;

    public function delete(string $key): bool;

    public function setItem(string $key, mixed $value, ?int $expires = null): void;
}