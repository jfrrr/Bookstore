<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    // Relasi Database

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Menghitung total harga seluruh buku yang ada di dalam keranjang belanja.
     * Selalu dihitung di sisi server berdasarkan harga snapshot database.
     */
    public function total(): float
    {
        return $this->items->sum(fn ($item) => $item->price * $item->quantity);
    }
}
