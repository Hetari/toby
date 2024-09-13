<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;

class CachedCollectionRepository extends CollectionRepository
{
    protected $collectionRepository;

    public function __construct(CollectionRepository $collectionRepository)
    {
        $this->collectionRepository = $collectionRepository;
    }

    public function all(array $relations = [])
    {
        $cacheKey = 'collections.all';
        if (Cache::has($cacheKey)) {
            $fromCache = true;
        } else {
            $fromCache = false;
        }

        // TODO: remove the unnecessary keys
        return [
            'data' => Cache::remember($cacheKey, 3600, function () use ($relations) {
                return $this->collectionRepository->all($relations);
            }),
            'from_cache' => $fromCache
        ];
    }

    public function find($id, array $relations = [])
    {
        $cacheKey = 'collections.find';
        if (Cache::has($cacheKey)) {
            $fromCache = true;
        } else {
            $fromCache = false;
        }

        // TODO: remove the unnecessary keys
        return [
            'data' => Cache::remember($cacheKey, 3600, function () use ($id, $relations) {
                return $this->collectionRepository->find($id, $relations);
            }),
            'from_cache' => $fromCache
        ];
    }
}
