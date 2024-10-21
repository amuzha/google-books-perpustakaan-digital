<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('query');

        $authors = Author::where('name', 'LIKE', '%' . $query . '%')->get();

        if ($authors->isEmpty()) {
            return response()->json([]);
        }

        return response()->json($authors);
    }

    public function autocomplete(Request $request)
    {
        $term = $request->input('term');
        $authors = Author::where('name', 'LIKE', "%$term%")->pluck('name');
        return response()->json($authors);
    }
}
