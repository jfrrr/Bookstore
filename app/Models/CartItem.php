<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'book_id',
        'quantity',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'quantity' => 'integer',
        ];
    }

    // Relasi Database

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /** Menghitung subtotal untuk item ini (harga × kuantitas). */
    public function subtotal(): float
    {
        return $this->price * $this->quantity;
    }
}
