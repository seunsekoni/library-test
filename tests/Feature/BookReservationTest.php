<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Book;

class BookReservationTest extends TestCase
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
        
        $response = $this->post('books', [
            'title' => 'First Book Title',
            'author' => 'Sekoni Seun'
        ]);

        // Assert that the response was ok
        $response->assertOk();
        // Assert the book count is 1
        $this->assertCount(1, Book::all());
    }

    public function test_if_a_book_has_title_validation()
    {
        // $this->withoutExceptionHandling();
        
        $response = $this->post('books', [
            'title' => '',
            'author' => 'Sekoni Seun'
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_if_a_book_has_author_validation()
    {
        // $this->withoutExceptionHandling();
        
        $response = $this->post('books', [
            'title' => 'New Title',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    /** @test */
    public function test_if_a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();

        
        $this->post('books', [
            'title' => 'Actual Title',
            'author' => 'Sekoni Seun'
        ]);

        $book = Book::first();
   
        $this->patch('update/books/'.$book->id, [
            'title' => 'New Title',
            'author' => 'Sekoni Seun'
        ]);
            
        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('Sekoni Seun', $book->author);
    }
}
