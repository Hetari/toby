<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;


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

        $result = Cache::remember($cacheKey, 3600, function () use ($relations) {
            return $this->tagRepository->all($relations);
        });

        return
            Cache::remember($cacheKey, 3600, function () use ($relations) {
                return $this->tagRepository->all($$relations);
            });
    }

    public function find($id, array $relations = [])
    {
        $cacheKey = 'tags.find';
        if (Cache::has($cacheKey)) {
            $fromCache = true;
        } else {
            $fromCache = false;
        }

        return  Cache::remember($cacheKey, 3600, function () use ($id, $relations) {
            return $this->tagRepository->find($id, $relations);
        });
    }
}
