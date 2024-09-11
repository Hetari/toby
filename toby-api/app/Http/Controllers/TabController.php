<?php

namespace App\Http\Controllers;

use App\Models\Tab;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TabController extends Controller
{
    // Create a new Tab
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'collection_id' => 'required|exists:collections,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $tab = Tab::create([
                'title' => $request->title,
                'url' => $request->url,
                'collection_id' => $request->collection_id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tab created successfully',
                'data' => $tab,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating tab',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Get All Tabs
    public function index(Request $request)
    {
        try {
            $tabs = Tab::with('collection')
                ->whereHas('collection', function ($query) use ($request) {
                    $query->where('user_id', $request->user()->id);
                })
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'OK',
                'data' => $tabs,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Delete a Tab
    public function destroy($id)
    {
        try {
            $tab = Tab::findOrFail($id);
            $tab->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tab deleted successfully',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Update a Tab
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'url' => 'sometimes|url',
            'collection_id' => 'sometimes|exists:collections,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $tab = Tab::findOrFail($id);

            if ($request->has('title')) {
                $tab->title = $request->title;
            }
            if ($request->has('url')) {
                $tab->url = $request->url;
            }
            if ($request->has('collection_id')) {
                $tab->collection_id = $request->collection_id;
            }

            $tab->save();

            return response()->json([
                'success' => true,
                'message' => 'Tab updated successfully',
                'data' => $tab,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
