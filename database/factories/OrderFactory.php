<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'order_number' => 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(4)),
            'customer_name' => fake()->name(),
            'phone' => '08' . fake()->numerify('##########'),
            'delivery_address' => fake()->address(),
            'payment_method' => 'cod',
            'status' => 'pending',
            'subtotal' => 150000,
            'total' => 150000,
        ];
    }
}
