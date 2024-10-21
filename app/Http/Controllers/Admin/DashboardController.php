<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Books;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $books = Books::all();
        return view('admin.dashboard', compact('books'));
    }
}
