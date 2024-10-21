<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Books;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $bookCount = Books::count();
        $authorCount = Author::count();
        $publisherCount = Books::distinct('publisher')->count('publisher');

        $books = Books::orderBy('page_count', 'desc')->paginate(12);
        $newBooks = Books::orderBy('published_date', 'desc')->limit(7)->get();

        $bannerBooks = Books::whereNotNull('cover_image')
            ->whereHas('author', function ($query) {
                $query->whereNotNull('name')
                    ->where('name', '!=', 'Unknown Author');
            })
            ->inRandomOrder()
            ->first();

        $categoriesCount = Category::withCount('books')
            ->having('books_count', '>', 5)
            ->orderBy('books_count', 'desc')
            ->take(4)
            ->pluck('name', 'books_count');

        $topCategories = Category::withCount('books')
            ->having('books_count', '>', 0)
            ->orderBy('books_count', 'desc')
            ->limit(6)
            ->get();

        $topAuthors = Author::withCount('books')
            ->whereNotNull('name')
            ->where('name', '!=', 'Unknown Author')
            ->orderBy('books_count', 'desc')
            ->limit(8)
            ->get();

        return view('user.index', [
            'books' => $books,
            'bannerBooks' => $bannerBooks,
            'newBooks' => $newBooks,
            'categoriesCount' => $categoriesCount,
            'bookCount' => $bookCount,
            'authorCount' => $authorCount,
            'publisherCount' => $publisherCount,
            'topCategory' => $topCategories,
            'topAuthors' => $topAuthors
        ]);
    }
}
