<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\Admin\AdminBookController;
use App\Http\Controllers\Admin\AuthorsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/{id}/book/{slug}', [BookController::class, 'show'])->name('user.show');
Route::get('/search', [BookController::class, 'search'])->name('user.search');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('books')->name('books.')->group(function () {
        Route::get('add', [AdminBookController::class, 'create'])->name('create');
        Route::get('{book}/edit', [AdminBookController::class, 'edit'])->name('edit');

        Route::get('/', [AdminBookController::class, 'index'])->name('index');
        Route::post('store', [AdminBookController::class, 'store'])->name('store');
        Route::put('{book}/update', [AdminBookController::class, 'update'])->name('update');
        Route::get('{book}/delete', [AdminBookController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('autocomplete', [CategoryController::class, 'autocomplete'])->name('autocomplete');
    });

    Route::prefix('authors')->name('authors.')->group(function () {
        Route::get('autocomplete', [AuthorsController::class, 'autocomplete'])->name('autocomplete');
        Route::get('search', [AuthorsController::class, 'search'])->name('search');
    });
});
