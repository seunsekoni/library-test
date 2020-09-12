<?php

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
Route::get('/', function() {
    return view('welcome');
});
Route::patch('update/books/{book}', 'BooksController@update');
Route::post('books', 'BooksController@store');
Route::delete('delete/book/{book}', 'BooksController@destroy');
Route::get('books', 'BooksController@index');

Route::post('author', 'AuthorsController@store');
Route::post('checkout/book/{book}', 'CheckoutBookController@store');
Route::post('checkin/book/{book}', 'CheckinBookController@store');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
