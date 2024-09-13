<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;

class CachedTabRepository extends TagRepository
{
    protected $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function all(array $relations = [])
    {
        $cacheKey = 'tags.all';
        if (Cache::has($cacheKey)) {
            $fromCache = true;
        } else {
            $fromCache = false;
        }

        // TODO: remove the unnecessary keys
        return [
            'data' => Cache::remember($cacheKey, 3600, function () use ($relations) {
                return $this->tagRepository->all($relations);
            }),
            'from_cache' => $fromCache
        ];
    }

    public function find($id, array $relations = [])
    {
        $cacheKey = 'tags.find';
        if (Cache::has($cacheKey)) {
            $fromCache = true;
        } else {
            $fromCache = false;
        }

        // TODO: remove the unnecessary keys
        return [
            'data' => Cache::remember($cacheKey, 3600, function () use ($id, $relations) {
                return $this->tagRepository->find($id, $relations);
            }),
            'from_cache' => $fromCache
        ];
    }
}
