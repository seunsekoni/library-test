<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book;
use Validator;

class BooksController extends Controller
{
    public function store()
    {
        $data = $this->validateRequest();
        Book::create($data);
    }

    public function update(Book $book)
    {
        $data = $this->validateRequest();
        $book->update($data);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect('/books');
    }

    protected function validateRequest()
    {
        return request()->validate([
            'title' => 'required', 
            'author_id' => 'required'
        ]);
    }
}
