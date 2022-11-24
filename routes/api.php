<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Book;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/searchTitle', function(){
    $myquery = \Illuminate\Support\Facades\Request::input('query');  // resources/js/components/Autocomplete.vue
    $books = Book::where('title','like','%'.$myquery.'%')->get();
    return response()->json($books);
});

Route::get('/searchAuthor', function(){
    $myquery = \Illuminate\Support\Facades\Request::input('query');  // resources/js/components/Autocomplete.vue
    $books = Book::where('author','like','%'.$myquery.'%')->get();
    return response()->json($books);
});
