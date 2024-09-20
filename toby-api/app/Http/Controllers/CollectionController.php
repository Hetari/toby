<?php

namespace App\Http\Controllers;

use App\Services\CollectionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;


class CollectionController extends Controller
{
    protected $collectionService;

    public function __construct(CollectionService $collectionService)
    {
        $result = $this->collectionService = $collectionService;

        return response()->json($result);
    }


    public function index(string $id = null, array $relations = null)
    {
        Cache::forget('collections.all');

        $validator = Validator::make(['id' => $id], [
            'id' => ['nullable', 'exists:collections,id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors(),
            ], Response::HTTP_NOT_FOUND);
        }


        if ($id) {
            $result = $this->collectionService->getCollectionById($id, $relations);
        } else {
            $result = $this->collectionService->getAllCollections($relations);
        }

        if ($result instanceof \Illuminate\Http\JsonResponse) {
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
        Cache::forget('collections.all');


        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'is_fav' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

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

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'is_fav' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $idValidator = Validator::make(['id' => $id], [
            'id' => ['required', 'exists:collections,id'],
        ]);
        if ($idValidator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Not found',
                'errors' => $idValidator->errors(),
            ], Response::HTTP_NOT_FOUND);
        }

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

        $idValidator = Validator::make(['id' => $id], [
            'id' => ['required', 'exists:collections,id'],
        ]);
        if ($idValidator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Not found',
                'errors' => $idValidator->errors(),
            ], Response::HTTP_NOT_FOUND);
        }

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