<?php

namespace App\Http\Controllers;

use App\Services\CollectionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class CollectionController extends Controller
{
    protected $collectionService;

    public function __construct(CollectionService $collectionService)
    {
        $result = $this->collectionService = $collectionService;

        return response()->json($result);
    }


    public function index($id = null, $relations = null)
    {
        if ($id) {
            $result = $this->collectionService->getCollectionById($id, $relations);
        } else {
            $result = $this->collectionService->getAllCollections($relations);
        }

        // Ensure $result is always wrapped in a response
        if ($result instanceof \Illuminate\Http\JsonResponse) {
            // If it's already a JsonResponse, return it as is
            return $result;
        }

        return response()->json([
            'success' => true,
            'message' => 'Collections retrieved successfully',
            'data' => $result,
            'errors' => [],
        ], Response::HTTP_OK);
    }


    // Store a new collection
    public function store(Request $request)
    {
        $result = $this->collectionService->createCollection($request->all());
        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result;
        }
        return response()->json([
            'success' => true,
            'message' => 'Collection created successfully',
            'data' => $result,
            'errors' => [],
        ], Response::HTTP_OK);
    }

    // Update a collection
    public function update(Request $request, $id)
    {
        Cache::forget('collections.all');
        Cache::forget('collections.find.' . $id);

        $result = $this->collectionService->updateCollection($id, $request->all());
        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result;
        }
        return response()->json([
            'success' => true,
            'message' => 'Collection updated successfully',
            'data' => $result,
            'errors' => [],
        ], Response::HTTP_OK);
    }

    // Delete a collection
    public function destroy($id)
    {
        Cache::forget('collections.all');
        Cache::forget('collections.find.' . $id);

        $result = $this->collectionService->deleteCollection($id);
        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result;
        }

        return response()->json([
            'success' => true,
            'message' => 'Collection deleted successfully',
            'data' => $result,
            'errors' => [],
        ], Response::HTTP_OK);
    }
}
