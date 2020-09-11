<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Book;
use App\Models\Author;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();
        
        $response = $this->post('books', $this->data());

        // Assert that the response was ok
        $response->assertOk();
        // Assert the book count is 1
        $this->assertCount(1, Book::all());
    }

    public function test_if_a_book_has_title_validation()
    {
        // $this->withoutExceptionHandling();
        
        $response = $this->post('books', array_merge($this->data(), ['title' => '']));

        $response->assertSessionHasErrors('title');
    }

    public function test_if_a_book_has_author_validation()
    {
        // $this->withoutExceptionHandling();
        
        $response = $this->post('books', array_merge($this->data(), ['author_id' => '']));

        $response->assertSessionHasErrors('author_id');
    }

    /** @test */
    public function test_if_a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();

        
        $this->post('books', $this->data());

        $book = Book::first();
   
        $this->patch('update/books/'.$book->id, [
            'title' => 'New Title',
            'author_id' => 1
        ]);
            
        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals(1, Book::first()->author_id);
    }

    /** @test */
    public function test_if_a_book_can_be_deleted()
    {
        // $this->withoutExceptionHandling();

        $this->post('books', $this->data());

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete('delete/book/'.$book->id);

        $this->assertCount(0, Book::all());
        // assert redirect
        $response->assertRedirect('/books');

    }

    public function test_if_a_new_author_can_be_created_automatically()
    {
        $this->withoutExceptionHandling();
        $this->post('books', [
            'title' => 'Delete Title Book',
            'author_id' => 1
        ]);

        $author = Author::first();
        $book = Book::first();

        // dd($book);

        $this->assertEquals($author->id, (int)$book->author_id);
        // $this->assertCount(1, Author::all());
    }

    private function data()
    {
        return [
            'title' => 'First Book Title',
            'author_id' => 1
        ];
    }
}
