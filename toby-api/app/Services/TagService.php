<?php

namespace App\Services;

use App\Repositories\CachedTabRepository;
use App\Repositories\TagRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TagService
{
    protected $tagRepository;
    protected $cacheTagRepository;

    public function __construct(TagRepository $tagRepository, CachedTabRepository $cacheTagRepository)
    {
        $this->tagRepository = $tagRepository;
        $this->cacheTagRepository = $cacheTagRepository;
    }

    public function getAllTags()
    {
        $result = null;
        try {
            $result = $this->cacheTagRepository->all();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting tag',
                'error' => $e->getMessage(),
                'data' => $result,

            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $result;
    }

    public function getTagById($id)
    {
        $result = null;
        try {
            $result = $this->cacheTagRepository->find($id);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting tag',
                'error' => $e->getMessage(),
                'data' => $result,

            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $result;
    }

    public function createTag($data)
    {
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors(),
                'data' => [],
            ], Response::HTTP_BAD_REQUEST);
        }

        $data['user_id'] =
            Auth::guard('api')->user()->id ? Auth::guard('api')->user()->id : Auth::id();

        try {
            $result = $this->tagRepository->create($data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating tag',
                'error' => $e->getMessage(),
                'data' => [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json([
            'success' => true,
            'message' => 'Tag created successfully',
            'errors' => [],
            'data' => $result,
        ], Response::HTTP_CREATED);
    }

    public function updateTag($id, $data)
    {
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors(),
                'data' => [],
            ], Response::HTTP_BAD_REQUEST);
        }

        $data['user_id'] =
            Auth::guard('api')->user()->id ? Auth::guard('api')->user()->id : Auth::id();

        try {
            $result = $this->tagRepository->update($id, $data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating tag',
                'error' => $e->getMessage(),
                'data' => [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tag updated successfully',
            'data' => $result,
            'errors' => [],
        ], Response::HTTP_OK);
    }

    public function deleteTag($id)
    {
        try {
            $result = $this->tagRepository->delete($id);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting tag',
                'errors' => $e->getMessage(),
                'data' => [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tag deleted successfully',
            'errors' => [],
            'data' => $result,
        ], Response::HTTP_OK);
    }
}
