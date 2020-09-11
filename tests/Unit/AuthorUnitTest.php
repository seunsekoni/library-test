<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Author;

class AuthorUnitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_if_only_name_can_be_used_to_create_an_author()
    {
        // $this->withoutExceptionHandling();

        Author::firstOrCreate([
            'name' => 'John Doe'
        ]);

        $this->assertCount(1, Author::all());
    }
}
