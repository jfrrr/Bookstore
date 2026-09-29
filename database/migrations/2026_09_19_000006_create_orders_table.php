<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create orders table. Stores customer snapshot data so historical orders
 * remain accurate even if user profile changes later.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->string('order_number')->unique()->index();
            $table->string('customer_name');
            $table->string('phone');
            $table->text('delivery_address');
            $table->string('payment_method')->default('payment_at_delivery');
            $table->enum('status', ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'])
                  ->default('pending')
                  ->index();
            $table->decimal('subtotal', 12, 2);
            $table->decimal('total', 12, 2);
            $table->timestamps();

            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
