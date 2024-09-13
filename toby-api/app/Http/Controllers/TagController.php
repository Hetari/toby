<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Collection;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    protected $tagService;
    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    // Create a new Tag
    public function store(Request $request)
    {
        $result = $this->tagService->createTag($request->all());
        return $result;
    }

    // Get All Tags, on a Collection by ID
    public function index(Request $request, $id = null)
    {
        $result = $this->tagService->getAllTags($id);
        return response()->json($result);
    }


    // Delete a Tag
    public function destroy($id)
    {
        $result = $this->tagService->deleteTag($id);
        return response()->json($result);
    }

    // Update a Tag
    public function update(Request $request, $id)
    {
        $result = $this->tagService->updateTag($id, $request->all());
        return response()->json($result);
    }
}
