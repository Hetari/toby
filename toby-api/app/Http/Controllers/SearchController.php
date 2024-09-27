<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tab;
use App\Models\Collection;
use App\Models\Tag;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'type' => ['required', 'in:tab,collection,tag,all'],
            'search' => ['required', 'string'],
        ]);


        // Perform the search based on the type provided
        return match ($request->type) {
            'tab' => Tab::where('title', 'LIKE', '%' . $request->search . '%')->get(),
            'collection' => Collection::where('title', 'LIKE', '%' . $request->search . '%')->get(),
            'tag' => Tag::where('title', 'LIKE', '%' . $request->search . '%')->get(),
            'all' => [
                'tabs' => Tab::where('title', 'LIKE', '%' . $request->search . '%')->get(),
                'collections' => Collection::where('title', 'LIKE', '%' . $request->search . '%')->get(),
                'tags' => Tag::where('title', 'LIKE', '%' . $request->search . '%')->get(),
            ],

            default => response()->json(['error' => 'Invalid search type'], 400),
        };
    }
}