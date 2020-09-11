<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Author;
use Carbon\Carbon;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

   public function test_if_an_author_can_be_created()
   {
    //    $this->withoutExceptionHandling();

       $this->post('author', [
           'name' => 'Author One',
           'dob' => '05-09-1998'
       ]); 
       $authors = Author::all();
       $this->assertCount(1, $authors);
       $this->assertInstanceOf(Carbon::class, $authors->first()->dob);
       $this->assertEquals('1998/09/05', $authors->first()->dob->format('Y/m/d'));
   }
}
