<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;


class CachedTagRepository extends TagRepository
{
    protected $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function all(array $relations = null)
    {
        $cacheKey = 'tags.all';

        $result = Cache::remember($cacheKey, 3600, function () use ($relations) {
            return $this->tagRepository->all($relations);
        });

        return $result;
    }

    public function find($id, array $relations = null)
    {
        $cacheKey = 'tags.find.' . $id;

        $result = Cache::remember($cacheKey, 3600, function () use ($id, $relations) {
            return $this->tagRepository->find($id, $relations);
        });

        return $result;
    }
}
