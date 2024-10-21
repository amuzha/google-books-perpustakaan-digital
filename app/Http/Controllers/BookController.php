<?php
namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Books;
use App\Models\Category;
use Exception;
use \Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    public function show($id, $slug)
    {
        $book = Books::where('id', $id)->where('slug', $slug)->firstOrFail();

        return view('user.books', [
            'book' => $book
        ]);
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('query');

        $categories = Category::all();

        // Initialize the query for books
        $booksQuery = Books::query();

        // Apply search query filter
        if (strlen($searchQuery) === 1) {
            $booksQuery->where('title', 'LIKE', "$searchQuery%");
        } else {
            $booksQuery->where(function ($query) use ($searchQuery) {
                $query->where('title', 'LIKE', "%$searchQuery%")
                    ->orWhereHas('author', function ($query) use ($searchQuery) {
                        $query->where('name', 'LIKE', "%$searchQuery%");
                    })
                    ->orWhereHas('categories', function ($query) use ($searchQuery) {
                        $query->where('categories.name', 'LIKE', "%$searchQuery%"); // Specify the table
                    });
            });
        }

        // Apply category filter
        if ($request->has('categories')) {
            $selectedCategories = $request->input('categories');
            $booksQuery->whereHas('categories', function ($query) use ($selectedCategories) {
                $query->whereIn('categories.id', $selectedCategories); // Specify the table
            });
        }

        // Apply price filter
        if ($request->has('price')) {
            $prices = $request->input('price');
            switch($prices) {
                case 'free':
                    $booksQuery->where('price', 0);
                    break;
                case 'cheap':
                    $booksQuery->orderBy('price', 'asc');
                    break;
                case 'expensive':
                    $booksQuery->orderBy('price', 'desc');
                    break;
            }
        }

        if ($request->has('options')) {
            $option = $request->input('options');
            switch ($option) {
                case 'newest':
                    $booksQuery->orderBy('published_date', 'desc');
                    break;
                case 'oldest':
                    $booksQuery->orderBy('published_date', 'asc');
                    break;
                case 'popular':
                    $booksQuery->orderBy('page_count', 'desc');
                    break;
                case 'lowest':
                    $booksQuery->orderBy('page_count', 'asc');
                    break;
            }
        }

        // Fetch books based on the query
        $books = $booksQuery->get();

        // If fewer books are found than a certain threshold, fetch additional books from an API
        if ($books->count() < 12) {
            $fetchedBooks = Books::fetchBooksFromApi($searchQuery);

            $fetchedIsbns = array_column($fetchedBooks, 'isbn');
            $existingIsbns = Books::whereIn('isbn', $fetchedIsbns)->pluck('isbn')->toArray();

            $booksToInsert = array_filter($fetchedBooks, function ($book) use ($existingIsbns) {
                return !in_array($book['isbn'], $existingIsbns);
            });

            foreach ($booksToInsert as $book) {
                $newBook = Books::create([
                    'title' => $book['title'],
                    'author_id' => $book['author_id'],
                    'publisher' => $book['publisher'],
                    'published_date' => $book['published_date'],
                    'description' => $book['description'],
                    'page_count' => $book['page_count'],
                    'language' => $book['language'],
                    'price' => $book['price'],
                    'cover_image' => $book['cover_image'],
                    'slug' => $book['slug'],
                    'isbn' => $book['isbn'],
                ]);

                if (!empty($book['categories'])) {
                    $categoryIds = Category::whereIn('name', explode(', ', $book['categories']))->pluck('id')->toArray();
                    $newBook->categories()->sync($categoryIds);
                }
            }

            // Refresh the books after inserting new ones
            $books = $booksQuery->get();
        }

        return view('user.search', compact('books', 'searchQuery', 'categories'));
    }


}
