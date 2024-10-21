<?php

namespace App\Models;

use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Books extends Model
{
    public const API_URL = "https://www.googleapis.com/books/v1/volumes?q=";
    public const API_KEY = "AIzaSyBV-Hj90dZC2PIz_HGq1SCNUXsIYNUcID8";
    public const BOOKS_PER_SEARCH = 40;

    use HasFactory;
    protected $guarded = [];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_category', 'book_id', 'category_id')->withTimestamps();
    }

    public static function fetchBooksFromApi($query)
    {
        $books = [];
        $categories = [];
        $startIndex = 0;
        $maxResults = 40;
        $maxPages = 5;

        for ($page = 0; $page < $maxPages; $page++) {
            $apiUrl = self::API_URL . urlencode($query) . '&startIndex=' . $startIndex . '&maxResults=' . $maxResults . '&key=' . self::API_KEY;
            $response = file_get_contents($apiUrl);
            $data = json_decode($response, true);

            if (isset($data['items'])) {
                foreach ($data['items'] as $item) {
                    $title = $item['volumeInfo']['title'] ?? 'No title';
                    $authors = $item['volumeInfo']['authors'] ?? ['Unknown author'];
                    $publisher = $item['volumeInfo']['publisher'] ?? 'Unknown publisher';
                    $published_date = $item['volumeInfo']['publishedDate'] ?? '';
                    $description = $item['volumeInfo']['description'] ?? '';
                    $page_count = $item['volumeInfo']['pageCount'] ?? 0;
                    $averageRating = $item['volumeInfo']['averageRating'] ?? 0.00;
                    $ratingsCount = $item['volumeInfo']['ratingsCount'] ?? 0;
                    $categoriesArray = $item['volumeInfo']['categories'] ?? [];
                    $categories = array_merge($categories, $categoriesArray);
                    $language = $item['volumeInfo']['language'] ?? '';
                    $cover_image = $item['volumeInfo']['imageLinks']['thumbnail'] ?? 'public/storage/img/books-cover/default_cover.jpg';
                    $cover_image_large = $item['volumeInfo']['imageLinks']['large'] ?? 'public/storage/img/books-cover/default_cover.jpg';
                    $price = $item['saleInfo']['listPrice']['amount'] ?? 0.00;
                    $isbn = $item['volumeInfo']['industryIdentifiers'][0]['identifier'] ?? '';
                    $buy_link = $item['saleInfo']['buyLink'] ?? '';
                    $epubAvailable = $item['accessInfo']['epub']['isAvailable'] ?? false;
                    $pdfAvailable = $item['accessInfo']['pdf']['isAvailable'] ?? false;
                    $webReaderLink = $item['accessInfo']['webReaderLink'] ?? '';
                    $accessViewStatus = $item['accessInfo']['accessViewStatus'] ?? '';
                    $slug = Str::slug($title);

                    $acsTokenLink = '';
                    if ($pdfAvailable) {
                        $acsTokenLink = $item['accessInfo']['pdf']['acsTokenLink'] ?? '';
                    }

                    $formatted_date = null;
                    if ($published_date) {
                        try {
                            $date = new DateTime($published_date);
                            $formatted_date = $date->format('Y-m-d');
                        } catch (Exception $e) {
                            $formatted_date = null;
                        }
                    }

                    $authorIds = [];
                    foreach ($authors as $authorName) {
                        $authorName = trim($authorName);
                        if (!empty($authorName)) {
                            $author = Author::firstOrCreate(['name' => $authorName]);
                            $authorIds[] = $author->id;
                        }
                    }

                    $book = Books::updateOrCreate(
                        ['isbn' => $isbn],
                        [
                            'title' => $title,
                            'author_id' => $authorIds[0] ?? null,
                            'publisher' => $publisher,
                            'published_date' => $formatted_date,
                            'description' => $description,
                            'page_count' => $page_count,
                            'average_rating' => $averageRating,
                            'ratings_count' => $ratingsCount,
                            'language' => $language,
                            'price' => $price,
                            'cover_image' => $cover_image,
                            'cover_image_large' => $cover_image_large,
                            'buy_link' => $buy_link,
                            'epub_available' => $epubAvailable,
                            'pdf_available' => $pdfAvailable,
                            'acs_token_link' => $acsTokenLink,
                            'web_reader_link' => $webReaderLink,
                            'access_view_status' => $accessViewStatus,
                            'slug' => $slug
                        ]
                    );

                    $uniqueCategories = array_unique(array_map('trim', $categoriesArray));
                    $categoryIds = Category::whereIn('name', $uniqueCategories)->pluck('id')->toArray();
                    $book->categories()->sync($categoryIds);
                }

                $uniqueCategories = array_unique(array_map('trim', $categories));
                foreach ($uniqueCategories as $categoryName) {
                    if (!empty($categoryName)) {
                        Category::firstOrCreate(['name' => $categoryName]);
                    }
                }
            }

            $startIndex += $maxResults;
        }

        return $books;
    }

    public static function fetchCategoryFromApi($query)
    {
        $apiUrl = self::API_URL . urlencode($query) . '&maxResults=' . self::BOOKS_PER_SEARCH . '&key=' . self::API_KEY;
        $response = file_get_contents($apiUrl);
        $data = json_decode($response, true);

        $categories = [];
        if (isset($data['items'])) {
            foreach ($data['items'] as $item) {
                $categoriesArray = $item['volumeInfo']['categories'] ?? [];
                foreach ($categoriesArray as $categoryName) {
                    $categoryName = trim($categoryName);
                    if (!empty($categoryName) && !in_array($categoryName, $categories)) {
                        $categories[] = $categoryName;
                        Category::firstOrCreate(['name' => $categoryName]);
                    }
                }
            }
        }

        return $categories;
    }

    public static function fetchAuthorFromApi($query)
    {
        $apiUrl = self::API_URL . urlencode($query) . '&maxResults=' . self::BOOKS_PER_SEARCH . '&key=' . self::API_KEY;
        $response = file_get_contents($apiUrl);
        $data = json_decode($response, true);

        $authors = [];
        if (isset($data['items'])) {
            foreach ($data['items'] as $item) {
                if (isset($item['volumeInfo']['authors'])) {
                    foreach ($item['volumeInfo']['authors'] as $authorName) {
                        $authorName = trim($authorName);
                        if (!empty($authorName) && !in_array($authorName, $authors)) {
                            $authors[] = $authorName;

                            Author::firstOrCreate(['name' => $authorName]);
                        }
                    }
                }
            }
        }

        return $authors;
    }
}
