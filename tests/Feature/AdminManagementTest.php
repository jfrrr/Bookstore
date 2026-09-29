<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }

    public function test_admin_can_create_category(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post('/admin/categories', [
            'name'        => 'Sejarah & Budaya',
            'description' => 'Buku-buku sejarah nusantara dan peradaban dunia',
            'status'      => 'active',
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', [
            'name' => 'Sejarah & Budaya',
            'slug' => 'sejarah-budaya',
        ]);
    }

    public function test_admin_can_create_book(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/books', [
            'title'       => 'Refactoring: Improving the Design of Existing Code',
            'author'      => 'Martin Fowler',
            'category_id' => $category->id,
            'description' => 'Panduan wajib teknik refactoring untuk arsitektur kode profesional.',
            'price'       => 155000,
            'stock'       => 20,
            'status'      => 'active',
        ]);

        $response->assertRedirect(route('admin.books.index'));
        $this->assertDatabaseHas('books', [
            'title'  => 'Refactoring: Improving the Design of Existing Code',
            'author' => 'Martin Fowler',
            'stock'  => 20,
        ]);
    }

    public function test_admin_can_update_order_status(): void
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->create();
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'status'  => 'pending',
        ]);

        // Transition from pending -> confirmed
        $response = $this->actingAs($admin)->patch("/admin/orders/{$order->id}", [
            'status' => 'confirmed',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'id'     => $order->id,
            'status' => 'confirmed',
        ]);
    }
}
