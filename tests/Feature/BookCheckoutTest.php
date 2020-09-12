<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Book;
use App\Models\Reservation;
use Auth;

class BookCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_a_book_can_be_checked_out_by_a_signed_in_user()
    {
        // $this->withoutExceptionHandling();
        $book = Book::factory()->create();

        $this->actingAs($user = User::factory()->create())
            ->post('checkout/book/'.$book->id);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals(now(), Reservation::first()->checked_out_at);
    }

    public function test_if_only_signed_in_user_can_checkout_a_book()
    {
        // $this->withoutExceptionHandling();
        $book = Book::factory()->create();

        $this->post('checkout/book/'.$book->id)
            ->assertRedirect('/login');

        $this->assertCount(0, Reservation::all());
        
    }

    public function test_if_only_real_books_can_be_checked_out()
    {
        

        $this->actingAs($user = User::factory()->create())
            ->post('checkout/book/345')
            ->assertStatus(404);

        $this->assertCount(0, Reservation::all());
        
    }

    public function test_if_a_book_can_be_checked_in_by_a_signed_in_user()
    {
        $book = Book::factory()->create();

        $this->actingAs($user = User::factory()->create())
            ->post('checkout/book/'.$book->id);

        $this->actingAs($user)
            ->post('checkin/book/'.$book->id);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals(now(), Reservation::first()->checked_in_at);
    }

    public function test_if_only_signed_in_user_can_checkin_a_book()
    {
        // $this->withoutExceptionHandling();
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('checkout/book/'.$book->id);

        Auth::logout();

        $this->post('checkin/book/'.$book->id)
            ->assertRedirect('/login');

        $this->assertCount(1, Reservation::all());
        $this->assertNull(Reservation::first()->checked_in_at);
    }

    public function test_if_a_404_is_thrown_when_a_book_is_not_checked_out_first()
    {
        // $this->withoutExceptionHandling();
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('checkin/book/'.$book->id)
            ->assertStatus(404);

        $this->assertCount(0, Reservation::all());
    }
}
