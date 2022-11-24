<?php

use Illuminate\Support\Facades\Route;
use App\Models\Book;
use App\Events\NewBookInserted;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/books/cover',  [BookController::class, 'cover'])->name('books.cover');
Route::put('/books/{id}', [BookController::class, 'update'])->name('books.update');
Route::get('/books/mybooks', [BookController::class, 'mybooks'])->name('books.mybooks');
Route::get('/books/create/{related_id?}', [BookController::class, 'create'])->name('books.create');
Route::patch('/books/updateCustomerSort', [BookController::class, 'updateCustomerSort'])->name('books.updateCustomerSort');
Route::resource('/books', 'BookController')->except(['create', 'update']);



Route::get('testEvent', function (){
    $book = Book::query()->where('title', '=', 'parola del diavolo')->firstOrFail();

    event(new NewBookInserted($book));
}
);
