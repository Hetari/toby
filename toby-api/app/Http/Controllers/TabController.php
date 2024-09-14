<?php

namespace App\Http\Controllers;

use App\Services\TabService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class TabController extends Controller
{
    protected $tabService;

    public function __construct(TabService $tabService)
    {
        $this->tabService = $tabService;
    }

    public function store(Request $request)
    {
        $result = $this->tabService->createTab($request->all());

        return $result;
    }

    public function index($id = null, $relations = null)
    {
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

    public function update(Request $request, $id)
    {
        Cache::forget('tabs.all');
        Cache::forget('tabs.find.' . $id);

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
