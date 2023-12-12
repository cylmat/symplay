<?php

declare(strict_types=1);

namespace App\Data\Domain\Manager;

use App\AppBundle\Domain\CacheInterface;
use App\AppData\Domain\Manager\CustomScriptInterface;
use App\Data\Application\DTO\RandomApi;

final class RandomApiManager
{
    public function __construct(
        private readonly CacheInterface $cache,
        private readonly CustomScriptInterface $scriptManager,
    ) {
    }

    public function getData(): RandomApi
    {
        $item = $this->cache->get('cache.get', 'cache_get_'.\random_int(0, 10));
        $this->cache->set('cache.dynamic', 'cache_dynamic_'.\random_int(0, 10), 8);

        $randomApi = new RandomApi();
        $randomApi->random_int = \random_int(1, 99);
        $randomApi->random_script_int = $this->scriptManager->getCustomScript([]);
        $randomApi->cache_get = $item;
        $randomApi->cache_dynamic = $this->cache->get('cache.dynamic', fn () => 'nope');

        return $randomApi;
    }
}
