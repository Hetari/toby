<?php

namespace App\Services;

use App\Repositories\TagRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TagService
{
    protected $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function getAllTags()
    {
        $result = null;
        try {
            $result = $this->tagRepository->all();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating tag',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $result;
    }

    public function getTagById($id)
    {
        $result = null;
        try {
            $result = $this->tagRepository->find($id);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating tag',
                'error' => $e->getMessage(),
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
            ], Response::HTTP_BAD_REQUEST);
        }

        $data['user_id'] =
            Auth::guard('api')->user()->id ? Auth::guard('api')->user()->id : Auth::id();

        try {
            $this->tagRepository->create($data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating tag',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json([
            'success' => true,
            'message' => 'Tag created successfully',
            'errors' => [],
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
            ], Response::HTTP_BAD_REQUEST);
        }

        $data['user_id'] =
            Auth::guard('api')->user()->id ? Auth::guard('api')->user()->id : Auth::id();

        try {
            $this->tagRepository->update($id, $data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating tag',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json([
            'success' => true,
            'message' => 'Tag updated successfully',
            'errors' => [],
        ], Response::HTTP_OK);
    }

    public function deleteTag($id)
    {
        try {
            $this->tagRepository->delete($id);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tag deleted successfully',
        ], Response::HTTP_OK);
    }
}
