<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function autocomplete(Request $request)
    {
        $term = $request->input('term');
        $categories = Category::where('name', 'LIKE', "%$term%")->pluck('name');
        return response()->json($categories);
    }
}
