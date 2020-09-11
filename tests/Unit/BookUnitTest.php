<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Book;

class BookUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_an_author_id_is_recorded()
    {
        Book::create([
            'title' => 'Cool Title',
            'author_id' => 1,
        ]);

        $this->assertCount(1, Book::all());
    }
}
