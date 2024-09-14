<?php

namespace App\Http\Controllers;

use App\Services\TabService;
use Illuminate\Http\Request;

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
        return response()->json($result);
    }

    public function update(Request $request, $id)
    {
        $result = $this->tabService->updateTab($id, $request->all());
        return response()->json($result);
    }

    public function destroy($id)
    {
        $result = $this->tabService->deleteTab($id);
        return response()->json($result);
    }
}
