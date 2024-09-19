<?php

namespace App\Http\Controllers;

use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    protected $tagService;
    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    // Create a new Tag
    public function store(Request $request)
    {
        Cache::forget('tags.all');

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors(),
                'data' => [],
            ], Response::HTTP_BAD_REQUEST);
        }

        $result = $this->tagService->createTag($request->all());

        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result;
        }

        return response()->json([
            'success' => true,
            'message' => 'Tag created successfully',
            'data' => $result,
            'errors' => [],
        ], Response::HTTP_CREATED);
    }

    public function index($id = null, $relations = null)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => ['nullable', 'exists:tags,id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Not found',
                'errors' => $validator->errors(),
            ], Response::HTTP_NOT_FOUND);
        }

        if (isset($id)) {
            $result = $this->tagService->getTagById($id, $relations);
        } else {
            $result = $this->tagService->getAllTags($relations);
        }

        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result;
        }
        return response()->json([
            'success' => true,
            'message' => 'Tags retrieved successfully',
            'data' => $result,
            'errors' => [],
        ], Response::HTTP_OK);
    }


    // Delete a Tag
    public function destroy($id)
    {
        Cache::forget('tags.all');
        Cache::forget('tags.find.' . $id);

        $validator = Validator::make(['id' => $id], [
            'id' => ['required', 'exists:tags,id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Not found',
                'errors' => $validator->errors(),
            ], Response::HTTP_NOT_FOUND);
        }

        $result = $this->tagService->deleteTag($id);
        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result;
        }

        return response()->json([
            'success' => true,
            'message' => 'Tag deleted successfully',
            'data' => $result,
            'errors' => [],
        ], Response::HTTP_OK);
    }

    // Update a Tag
    public function update(Request $request, $id)
    {
        Cache::forget('tags.all');
        Cache::forget('tags.find.' . $id);

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors(),
                'data' => [],
            ], Response::HTTP_BAD_REQUEST);
        }

        $idValidator = Validator::make(['id' => $id], [
            'id' => ['required', 'exists:tags,id'],
        ]);
        if ($idValidator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Not found',
                'errors' => $idValidator->errors(),
            ], Response::HTTP_NOT_FOUND);
        }

        $result = $this->tagService->updateTag($id, $request->all());

        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result;
        }

        return response()->json([
            'success' => true,
            'message' => 'Tag updated successfully',
            'data' => $result,
            'errors' => [],
        ], Response::HTTP_OK);
    }
}
