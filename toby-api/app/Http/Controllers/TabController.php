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

    public function index(Request $request, $id = null)
    {
        $result = $this->tabService->getAllTabs($id);
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
