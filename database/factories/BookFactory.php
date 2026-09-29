<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        $title = fake()->sentence(3);
        return [
            'category_id' => Category::factory(),
            'title' => rtrim($title, '.'),
            'slug' => Str::slug($title) . '-' . Str::random(5),
            'author' => fake()->name(),
            'description' => fake()->paragraphs(3, true),
            'price' => fake()->numberBetween(50000, 300000),
            'stock' => fake()->numberBetween(5, 50),
            'cover_image' => null,
            'status' => 'active',
        ];
    }

    public function outOfStock(): static
    {
        return $this->state(fn () => ['stock' => 0]);
    }

    public function inactive(): static
    {
        return $this->state(fn () => ['status' => 'inactive']);
    }
}
