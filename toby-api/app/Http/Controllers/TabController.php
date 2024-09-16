<?php

namespace App\Http\Controllers;

use App\Models\Tab;
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
    private function _response_error(string $er ,int $statusCode){
        return response()->json([
            'success' => false,
            'message' => $er
        ],$statusCode);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'title'=> 'required|string|max:255',
                'url'=> 'nullable|string|max:255',
                'collection_id'=> 'required|exists:collections,id',
            ]);
            $tab = Tab::create($data);
            
            return response()->json([
                'success' =>true,
                'message' => 'Tabs created successfully',
                'data' => $tab
            ]);

        } catch (\Throwable $e) {
            return $this->_response_error($e->getMessage(), 400);
        }
    }

    public function index(Request $request)
    {
        try {
            $result = Tab::where('collection_id', $request->collection_id)->get();
        
            return response()->json([
                'success' => true,
                'message' => 'Tabs retrieved successfully',
                'data' => $result,
                'errors' => [],
            ], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return $this->_response_error($e->getMessage(), 400);
        }
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