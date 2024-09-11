<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    // Create a new Tag
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $tag = Tag::create([
                'title' => $request->title,
                'user_id' => $request->user()->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tag created successfully',
                'data' => $tag,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating tag',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Get All Tags
    public function index(Request $request)
    {
        try {
            $tags = Tag::with('collections')
                ->where('user_id', $request->user()->id)
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'OK',
                'data' => $tags,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Delete a Tag
    public function destroy($id)
    {
        try {
            $tag = Tag::findOrFail($id);
            $tag->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tag deleted successfully',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Update a Tag
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $tag = Tag::findOrFail($id);
            $tag->title = $request->title;
            $tag->save();

            return response()->json([
                'success' => true,
                'message' => 'Tag updated successfully',
                'data' => $tag,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
