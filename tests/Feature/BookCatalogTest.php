<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_book_catalog(): void
    {
        $category = Category::factory()->create(['name' => 'Fiksi Ilmiah']);
        $book = Book::factory()->create([
            'category_id' => $category->id,
            'title'       => 'Dune: Putra Gurun Pasir',
            'status'      => 'active',
        ]);

        $response = $this->get('/books');

        $response->assertStatus(200);
        $response->assertSee('Dune: Putra Gurun Pasir');
    }

    public function test_user_can_search_books_by_title(): void
    {
        $category = Category::factory()->create();
        Book::factory()->create([
            'category_id' => $category->id,
            'title'       => 'Clean Architecture',
            'status'      => 'active',
        ]);
        Book::factory()->create([
            'category_id' => $category->id,
            'title'       => 'Harry Potter',
            'status'      => 'active',
        ]);

        $response = $this->get('/books?search=Architecture');

        $response->assertStatus(200);
        $response->assertSee('Clean Architecture');
        $response->assertDontSee('Harry Potter');
    }

    public function test_user_can_view_book_details(): void
    {
        $category = Category::factory()->create();
        $book = Book::factory()->create([
            'category_id' => $category->id,
            'title'       => 'Atomic Habits',
            'author'      => 'James Clear',
            'price'       => 108000,
            'status'      => 'active',
        ]);

        $response = $this->get('/books/' . $book->slug);

        $response->assertStatus(200);
        $response->assertSee('Atomic Habits');
        $response->assertSee('James Clear');
        $response->assertSee('108.000');
    }

    public function test_inactive_book_is_hidden_from_public_catalog(): void
    {
        $category = Category::factory()->create();
        $book = Book::factory()->create([
            'category_id' => $category->id,
            'title'       => 'Buku Rahasia Draf',
            'status'      => 'inactive',
        ]);

        $response = $this->get('/books');
        $response->assertDontSee('Buku Rahasia Draf');
    }
}
