<?php

namespace App\Services;

use App\Repositories\CollectionRepository;
use App\Repositories\CachedCollectionRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CollectionService
{
    protected $collectionRepository;
    protected $cacheCollectionRepository;

    public function __construct(CollectionRepository $collectionRepository, CachedCollectionRepository $cacheCollectionRepository)
    {
        $this->collectionRepository = $collectionRepository;
        $this->cacheCollectionRepository = $cacheCollectionRepository;
    }

    public function getAllCollections($relations)
    {
        return $this->cacheCollectionRepository->all(['tabs']);
    }

    public function getCollectionById(
        $id,
        $relations
    ) {
        $result = null;
        try {
            $result = $this->cacheCollectionRepository->find($id, $relations);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting collection',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $result;
    }

    public function createCollection($data)
    {
        $data['user_id'] = Auth::guard('api')->user()->id ? Auth::guard('api')->user()->id : Auth::id();

        try {
            $this->collectionRepository->create($data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating collection',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'success' => true,
            'message' => 'Collection created successfully',
            'errors' => [],
        ], Response::HTTP_CREATED);
    }

    public function updateCollection($id, $data)
    {
        $data['user_id'] = Auth::guard('api')->user()->id ? Auth::guard('api')->user()->id : Auth::id();

        $collection = $this->collectionRepository->find($id);
        if ($collection->user_id !== $data['user_id']) {
            return response()->json([
                'success' => false,
                'message' => 'You are not the owner of this collection',
                'error' => 'Forbidden',
            ], Response::HTTP_FORBIDDEN);
        }

        try {
            $this->collectionRepository->update($id, $data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating collection',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'success' => true,
            'message' => 'Collection updated successfully',
            'errors' => [],
        ], Response::HTTP_OK);
    }

    public function deleteCollection($id)
    {
        $result = null;
        $data['user_id'] = Auth::guard('api')->user()->id ? Auth::guard('api')->user()->id : Auth::id();

        $collection = $this->collectionRepository->find($id);
        if ($collection->user_id !== $data['user_id']) {
            return response()->json([
                'success' => false,
                'message' => 'You are not the owner of this collection',
                'error' => 'Forbidden',
            ], Response::HTTP_FORBIDDEN);
        }

        try {
            $result = $this->collectionRepository->delete($id);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting tag',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $result;
    }
}
