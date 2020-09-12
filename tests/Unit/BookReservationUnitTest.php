<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Reservation;

use App\Models\Book;
use App\Models\User;
use Database\Factories\BookFactory;

class BookReservationUnitTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_if_a_book_can_be_checked_out()
    {

        $book = Book::factory()->create();
        $user = User::factory()->create();

        $book->checkout($user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals(now(), Reservation::first()->checked_out_at);
    }

    public function test_if_a_book_can_be_returned()
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $book->checkout($user);
        $book->checkin($user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals(now(), Reservation::first()->checked_in_at);
    }

    public function test_if_a_book_can_be_checked_out_twice()
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $book->checkout($user);
        $book->checkin($user);
        $book->checkout($user);

        $this->assertCount(2, Reservation::all());
        $this->assertEquals($book->id, Reservation::find(2)->book_id);
        $this->assertEquals($user->id, Reservation::find(2)->user_id);
        $this->assertNull(Reservation::find(2)->checked_in_at);
        $this->assertEquals(now(), Reservation::find(2)->checked_out_at);

        $book->checkin($user);

        $this->assertCount(2, Reservation::all());
        $this->assertEquals($book->id, Reservation::find(2)->book_id);
        $this->assertEquals($user->id, Reservation::find(2)->user_id);
        $this->assertNotNull(Reservation::find(2)->checked_in_at);
        $this->assertEquals(now(), Reservation::find(2)->checked_in_at);
    }

    public function test_if_not_checked_out()
    {
        $this->expectException(\Exception::class);
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $book->checkin($user);
    }

}
