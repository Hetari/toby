<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Tag;
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
            // Fetch collections
            $collections = Collection::with('tags')
                ->where('user_id', Auth::id())
                ->when($id, function ($query, $id) {
                    return $query->where('id', $id);
                })
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Collections retrieved',
                'data' => $collections,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Store a new collection
    public function store(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'is_fav' => 'nullable|boolean',
            'tagId' => 'nullable|exists:tags,id',
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
            // Create the collection
            $collection = Collection::create([
                'title' => $request->title,
                'is_fav' => $request->is_fav ?? false,
                'description' => $request->description ?? null,
                'user_id' => Auth::id(),
            ]);

            // Attach tag if provided
            if ($request->tagId) {
                $tag = Tag::find($request->tagId);
                if ($tag) {
                    $collection->tags()->attach($tag);
                }
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
                'tag_id' => $request->tagId ?? $collection->tag_id,
            ]);

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
