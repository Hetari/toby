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

    public function all(array $relations = [])
    {
        $cacheKey = 'tabs.all';
        if (Cache::has($cacheKey)) {
            $fromCache = true;
        } else {
            $fromCache = false;
        }

        return [
            'data' => Cache::remember($cacheKey, 60, function () use ($relations) {
                return $this->tabRepository->all($relations);
            }),
            'from_cache' => $fromCache
        ];

        // return Cache::remember('tabs', 3600, function () use ($relations) {
        //     return $this->tabRepository->all($relations);
        // });
    }

    public function find($id, array $relations = [])
    {
        $cacheKey = 'tabs.all';
        if (Cache::has($cacheKey)) {
            $fromCache = true;
        } else {
            $fromCache = false;
        }

        return [
            'data' => Cache::remember($cacheKey, 60, function () use ($id, $relations) {
                return $this->tabRepository->find($id, $relations);
            }),
            'from_cache' => $fromCache
        ];

        // return Cache::remember('tab_' . $id, 3600, function () use ($id, $relations) {
        //     return $this->tabRepository->find($id, $relations);
        // });
    }
}
