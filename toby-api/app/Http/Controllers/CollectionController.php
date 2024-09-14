<?php

namespace App\Http\Controllers;

use App\Services\CollectionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
        return response()->json($result);
    }


    // Store a new collection
    public function store(Request $request)
    {
        $result = $this->collectionService->createCollection($request->all());
        return $result;
    }

    // Update a collection
    public function update(Request $request, $id)
    {
        $result = $this->collectionService->updateCollection($id, $request->all());
        return response()->json($result);
    }

    // Delete a collection
    public function destroy($id)
    {
        $result = $this->collectionService->deleteCollection($id);
        return response()->json($result);
    }
}
