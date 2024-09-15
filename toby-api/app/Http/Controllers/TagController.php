<?php

namespace App\Http\Controllers;

use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

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

        $result = $this->tagService->createTag($request->all());
        return $result;
    }

    // Get All Tags, on a Collection by ID
    public function index($id = null, $relations = null)
    {
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
