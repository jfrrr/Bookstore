<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'author',
        'description',
        'price',
        'stock',
        'cover_image',
        'status',
        'is_bestseller',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
            'is_bestseller' => 'boolean',
        ];
    }

    // Relasi Database

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Query Scope Bantuan

    /** Hanya mengambil buku yang berstatus aktif untuk etalase publik. */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /** Menyaring buku yang ditandai sebagai produk terlaris (bestseller). */
    public function scopeBestseller($query)
    {
        return $query->where('is_bestseller', true);
    }

    /** Memeriksa apakah buku masih memiliki stok yang tersedia. */
    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    /**
     * Memformat harga buku ke mata uang Rupiah Indonesia.
     * Contoh: 85000.00 → Rp 85.000
     */
    public function formattedPrice(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
