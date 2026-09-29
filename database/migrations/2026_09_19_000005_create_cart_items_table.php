<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create cart_items table. Price is snapshotted at time of adding to cart.
 * A unique constraint on (cart_id, book_id) prevents duplicate cart rows.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('quantity');
            $table->decimal('price', 12, 2); // price snapshot at time of add
            $table->timestamps();

            $table->unique(['cart_id', 'book_id']);
            $table->index('cart_id');
            $table->index('book_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
