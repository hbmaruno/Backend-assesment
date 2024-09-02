<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::resource('books', BookController::class);
Route::get('books/{id?}', [BookController::class, 'index'])->name('books.index');
Route::get('books/import', [BookController::class, 'importForm'])->name('books.importForm');
Route::post('books/import', [BookController::class, 'importForm'])->name('books.import');
Route::post('books/store', [BookController::class, 'store'])->name('books.store');
Route::post('books/show', [BookController::class, 'store'])->name('books.show');
Route::post('books/edit', [BookController::class, 'edit'])->name('books.edit');
Route::post('books/destroy', [BookController::class, 'edit'])->name('books.destroy');
