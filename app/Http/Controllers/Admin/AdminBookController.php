<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Books;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminBookController extends Controller
{
    public function index()
    {
        $books = Books::all();
        return view('admin.books.index', compact('books'));
    }

    public function show(Books $book)
    {
        return view('admin.books.show', compact('book'));
    }

    public function edit(Books $book)
    {
        $categories = Category::all();
        $languages = [];

        $availableLanguages = Books::distinct('language')->pluck('language')->toArray();

        return view('admin.books.edit', compact('book', 'categories', 'availableLanguages'));
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'published_date' => 'required|date',
            'description' => 'required|string',
            'language' => 'required|string|max:255',
            'price' => 'required|numeric',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'isbn' => 'required|string|max:13|unique:books,isbn',
            'slug' => 'required|string|max:255|unique:books,slug'
        ]);

        // Handle author creation if necessary
        $authorId = $request->input('author_id');
        $authorName = $request->input('author');

        if (!$authorId) {
            $author = Author::firstOrCreate(['name' => $authorName]);
            $authorId = $author->id;
        }

        $data = $request->only([
            'title',
            'publisher',
            'published_date',
            'description',
            'language',
            'price',
            'isbn',
            'slug'
        ]);

        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/img/books-cover', $filename);
            $data['cover_image'] = str_replace('public/', '', $path);
        } else {
            $data['cover_image'] = 'public/storage/img/books-cover/default_cover.jpg';
        }

        $data['author_id'] = $authorId;

        Books::create($data);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function update(Request $request, Books $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'description' => 'required|string',
            'categories' => 'required|array',
            'categories.*' => 'integer|exists:categories,id',
            'language' => 'required|string|max:255',
            'isbn' => 'required|string|max:13|unique:books,isbn,' . $book->id,
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only([
            'title',
            'publisher',
            'description',
            'language',
            'isbn'
        ]);

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::delete('public/' . $book->cover_image);
            }

            $image = $request->file('cover_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/img/books-cover', $filename);
            $data['cover_image'] = str_replace('public/', './public/storage/', $path);
        }

        $book->update($data);

        $authorName = $request->input('author');
        $author = Author::firstOrCreate(['name' => $authorName]);
        $book->author_id = $author->id;

        $categoryIds = $request->input('categories');

        $book->categories()->sync($categoryIds);

        $book->save();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diupdate.');
    }

    public function destroy(Books $book)
    {
        // Delete cover image if it exists
        if ($book->cover_image) {
            Storage::delete('public/img/books-cover/' . $book->cover_image);
        }

        // Detach categories and delete them if they are no longer associated with any books
        foreach ($book->categories as $category) {
            $book->categories()->detach($category->id);

            // Check if category is no longer associated with any book
            if ($category->books()->count() == 0) {
                $category->delete();
            }
        }

        // Disassociate the author and delete if the author has no other books
        $author = $book->author;
        if ($author) {
            $book->author()->dissociate();

            // Check if author is no longer associated with any book
            if ($author->books()->count() == 0) {
                $author->delete();
            }
        }

        // Delete the book
        $book->delete();

        // Redirect with success message
        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus!');
    }

}
