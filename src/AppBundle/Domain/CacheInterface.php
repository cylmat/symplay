<?php

declare(strict_types=1);

namespace App\AppBundle\Domain;

/** @todo use "contracts" directory */
interface CacheInterface
{
    public function set(string $key, mixed $value, int $expires = null): void;
    
    public function get(string $key, callable $callback, float $beta = null, array &$metadata = null): mixed;
    
    public function delete(string $key): bool;
}
