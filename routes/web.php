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

Route::patch('update/books/{book}', 'BooksController@update');
Route::post('books', 'BooksController@store');
Route::delete('delete/book/{book}', 'BooksController@destroy');
Route::get('books', 'BooksController@index');

Route::post('author', 'AuthorsController@store');
