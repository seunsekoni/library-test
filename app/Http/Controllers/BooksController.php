<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book;
use Validator;

class BooksController extends Controller
{
    public function store(Request $request)
    {
        // $input = $request->all();
        // $rules = [
        //     'title' => 'required',
        //     'author' => 'required'
        // ];
        // $validator = Validator::make($input, $rules);
        $data = $this->validateRequest();
       
        Book::create($data);
    }

    public function update(Book $book, Request $request)
    {
        $data = $this->validateRequest();
        $book->update($data);
    }

    protected function validateRequest()
    {
        return $request->validate([
            'title' => 'required', 
            'author' => 'required'
        ]);
    }
}
