<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CollectionController extends Controller
{
    // Get all collections
    public function index(Request $request, $id = null)
    {
        try {
            $collections = Collection::with('tags')
                ->where('user_id', $id ?? $request->id)
                ->get();

        return response()->json($result);
    }


    public function index(string $id = null, array $relations = null)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => ['nullable', 'exists:collections,id'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Store a new collection
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'is_fav' => 'nullable|boolean',
            'tagId' => 'nullable|exists:tags,id',
            'description' => 'nullable|string',
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $collection = Collection::create([
                'title' => $request->title,
                'is_fav' => $request->is_fav ?? false,
                'description' => $request->description,
                'user_id' => $request->user_id,
            ]);

            if ($request->tagId) {
                $collection->tags()->attach($request->tagId);
            }

            return response()->json([
                'success' => true,
                'message' => 'Collection created',
                'data' => $collection,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    // Update a collection
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'tagId' => 'nullable|exists:tags,id',
            'description' => 'nullable|string',
            'is_fav' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $collection = Collection::where('id', $id)->where('user_id', Auth::id())->first();

            if (!$collection) {
                return response()->json([
                    'success' => false,
                    'message' => 'Collection not found',
                ], Response::HTTP_NOT_FOUND);
            }

            $collection->update([
                'title' => $request->title,
                'is_fav' => $request->is_fav ?? $collection->is_fav,
                'description' => $request->description ?? $collection->description,
            ]);

            if ($request->tagId) {
                $collection->tags()->sync($request->tagId);
            }

            return response()->json([
                'success' => true,
                'message' => 'Collection updated',
                'data' => $collection,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Delete a collection
    public function destroy($id)
    {
        try {
            $collection = Collection::where('id', $id)->where('user_id', Auth::id())->first();

            if (!$collection) {
                return response()->json([
                    'success' => false,
                    'message' => 'Collection not found',
                ], Response::HTTP_NOT_FOUND);
            }

            $collection->delete();

            return response()->json([
                'success' => true,
                'message' => 'Collection deleted',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}