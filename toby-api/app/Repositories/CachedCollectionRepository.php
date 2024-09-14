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

    public function all(array $relations = null)
    {
        $cacheKey = 'collections.all';

        return
            Cache::remember($cacheKey, 3600, function () use ($relations) {
                return $this->collectionRepository->all($relations);
            });
    }

    public function find($id, array $relations = null)
    {
        $cacheKey = 'collections.find.' . $id;

        return  Cache::remember($cacheKey, 3600, function () use ($id, $relations) {
            return $this->collectionRepository->find($id, $relations);
        });
    }
}
