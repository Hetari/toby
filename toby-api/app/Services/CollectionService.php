<?php

namespace App\Services;

use App\Repositories\CollectionRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CollectionService
{
    protected $collectionRepository;

    public function __construct(CollectionRepository $collectionRepository)
    {
        $this->collectionRepository = $collectionRepository;
    }

    public function getAllCollections()
    {
        return $this->collectionRepository->all();
    }

    public function getAllCollectionsWithTags()
    {
        // TODO: Implement getAllCollectionsWithTags() method.
    }

    public function getCollectionById($id)
    {
        $result = null;
        try {
            $result = $this->collectionRepository->find($id);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating tag',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $result;
    }

    public function getCollectionByIdWithCollection($id)
    {
        $result = null;
        try {
            $result = $this->collectionRepository->find($id, ['collection']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating tag',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $result;
    }

    public function createCollection($data)
    {
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'is_fav' => 'nullable|boolean',
            'tag_id' => 'nullable|exists:tags,id',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $data['user_id'] = Auth::id();

        try {
            $this->collectionRepository->create($data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating tag',
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
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'is_fav' => 'nullable|boolean',
            'tag_id' => 'nullable|exists:tags,id',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $this->collectionRepository->update($id, $data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating tag',
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
