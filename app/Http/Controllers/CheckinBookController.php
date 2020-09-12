<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book;

class CheckinBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function store(Book $book)
    {
        try {
            $book->checkin(auth()->user());
            
        } catch (\Throwable $th) {
            return \response([], 404);
        }
    }
}
