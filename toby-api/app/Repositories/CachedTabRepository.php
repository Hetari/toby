<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;

class CachedTabRepository extends TabRepository
{
    protected $tabRepository;

    public function __construct(TabRepository $tabRepository)
    {
        $this->tabRepository = $tabRepository;
    }

    public function all(array $relations = null)
    {
        $cacheKey = 'tabs.all';
        if (Cache::has($cacheKey)) {
            $fromCache = true;
        } else {
            $fromCache = false;
        }

        return Cache::remember($cacheKey, 3600, function () use ($relations) {
            return $this->tabRepository->all($relations);
        });

        // return Cache::remember('tabs', 3600, function () use ($relations) {
        //     return $this->tabRepository->all($relations);
        // });
    }

    public function find($id, array $relations = null)
    {
        $cacheKey = 'tabs.find';
        if (Cache::has($cacheKey)) {
            $fromCache = true;
        } else {
            $fromCache = false;
        }

        return Cache::remember($cacheKey, 3600, function () use ($id, $relations) {
            return $this->tabRepository->find($id, $relations);
        });

        // return Cache::remember('tab_' . $id, 3600, function () use ($id, $relations) {
        //     return $this->tabRepository->find($id, $relations);
        // });
    }
}
