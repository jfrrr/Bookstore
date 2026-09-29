<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartAndCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_cart(): void
    {
        $response = $this->get('/cart');
        $response->assertRedirect('/login');
    }

    public function test_user_can_add_book_to_cart(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $book = Book::factory()->create([
            'category_id' => $category->id,
            'stock'       => 10,
            'status'      => 'active',
        ]);

        $response = $this->actingAs($user)->post('/cart', [
            'book_id'  => $book->id,
            'quantity' => 2,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('cart_items', [
            'book_id'  => $book->id,
            'quantity' => 2,
        ]);
    }

    public function test_user_can_checkout_with_cod(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $book = Book::factory()->create([
            'category_id' => $category->id,
            'price'       => 100000,
            'stock'       => 10,
            'status'      => 'active',
        ]);

        // Add to cart
        $this->actingAs($user)->post('/cart', [
            'book_id'  => $book->id,
            'quantity' => 1,
        ]);

        // Checkout view
        $response = $this->actingAs($user)->get('/checkout');
        $response->assertStatus(200);

        // Submit checkout
        $response = $this->actingAs($user)->post('/checkout', [
            'name'             => 'Ahmad Jafar',
            'phone'            => '081234567890',
            'delivery_address' => 'Jl. Sudirman Kav 52-53, Kebayoran Baru, Jakarta Selatan',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'user_id'        => $user->id,
            'customer_name'  => 'Ahmad Jafar',
            'payment_method' => 'cod',
            'status'         => 'pending',
            'total'          => 100000,
        ]);

        // Stock deducted
        $this->assertDatabaseHas('books', [
            'id'    => $book->id,
            'stock' => 9,
        ]);
    }

    public function test_user_can_view_their_orders_list(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/orders');
        $response->assertStatus(200);
        $response->assertSee('Riwayat Pesanan Saya');
    }

    public function test_user_can_view_order_tracking_detail(): void
    {
        $user = User::factory()->create();
        $order = \App\Models\Order::create([
            'order_number'     => 'ORD-20260919-TEST',
            'user_id'          => $user->id,
            'customer_name'    => 'Ahmad Jafar',
            'phone'            => '081234567890',
            'delivery_address' => 'Jl. Sudirman No 1',
            'payment_method'   => 'cod',
            'status'           => 'processing',
            'subtotal'         => 150000,
            'shipping_cost'    => 0,
            'total'            => 150000,
        ]);

        $response = $this->actingAs($user)->get("/orders/{$order->id}");
        $response->assertStatus(200);
        $response->assertSee('ORD-20260919-TEST');
        $response->assertSee('Sedang Diproses');
        $response->assertSee('Status Progres Pengiriman');
    }

    public function test_user_cannot_view_another_users_order(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $order = \App\Models\Order::create([
            'order_number'     => 'ORD-20260919-OTHER',
            'user_id'          => $user1->id,
            'customer_name'    => 'User Satu',
            'phone'            => '081234567890',
            'delivery_address' => 'Jl. Sudirman No 1',
            'payment_method'   => 'cod',
            'status'           => 'shipped',
            'subtotal'         => 200000,
            'shipping_cost'    => 0,
            'total'            => 200000,
        ]);

        $response = $this->actingAs($user2)->get("/orders/{$order->id}");
        $response->assertStatus(403);
    }
}
