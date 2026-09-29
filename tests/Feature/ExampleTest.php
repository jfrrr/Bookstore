<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $category = Category::factory()->create();
        Book::factory()->count(3)->create(['category_id' => $category->id]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
