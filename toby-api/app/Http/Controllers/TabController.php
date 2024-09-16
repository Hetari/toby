<?php

namespace App\Http\Controllers;

use App\Services\TabService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class TabController extends Controller
{
    protected $tabService;

    public function __construct(TabService $tabService)
    {
        $this->tabService = $tabService;
    }

    public function index($id = null, $relations = null)
    {
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
            $result = $this->tabService->getTabById($id, $relations);
        } else {
            $result = $this->tabService->getAllTabs($relations);
        }

        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result;
        }

        return response()->json([
            'success' => true,
            'message' => 'Tabs retrieved successfully',
            'data' => $result,
            'errors' => [],
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        Cache::forget('tabs.all');

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255', 'min:3'],
            'url' => ['required', 'url'],
            'collection_id' => ['required', 'exists:collections,id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $result = $this->tabService->createTab($request->all());

        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result;
        }

        return response()->json([
            'success' => true,
            'message' => 'Tab created successfully',
            'data' => $result,
            'errors' => [],
        ], Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        Cache::forget('tabs.all');
        Cache::forget('tabs.find.' . $id);

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255', 'min:3'],
            'url' => ['required', 'url'],
            'collection_id' => ['required', 'exists:collections,id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $idValidator = Validator::make(['id' => $id], [
            'id' => ['required', 'exists:tabs,id'],
        ]);
        if ($idValidator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Not found',
                'errors' => $idValidator->errors(),
            ], Response::HTTP_NOT_FOUND);
        }

        $result = $this->tabService->updateTab($id, $request->all());
        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result;
        }
        return response()->json([
            'success' => true,
            'message' => 'Tab updated successfully',
            'data' => $result,
            'errors' => [],
        ], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        Cache::forget('tabs.all');
        Cache::forget('tabs.find.' . $id);

        $validator = Validator::make(['id' => $id], [
            'id' => ['required', 'exists:tabs,id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Not found',
                'errors' => $validator->errors(),
            ], Response::HTTP_NOT_FOUND);
        }

        $result = $this->tabService->deleteTab($id);
        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result;
        }

        return response()->json([
            'success' => true,
            'message' => 'Tab deleted successfully',
            'data' => $result,
            'errors' => [],
        ], Response::HTTP_OK);
    }
}
