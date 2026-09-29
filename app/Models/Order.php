<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'customer_name',
        'phone',
        'delivery_address',
        'payment_method',
        'status',
        'subtotal',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    // Relationships

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Method Bantuan (Helpers)

    /** Mendapatkan label teks yang mudah dipahami untuk status pesanan. */
    public function statusLabel(): string
    {
        return match($this->status) {
            'delivered', 'selesai' => 'Selesai',
            default                => 'Belum Selesai',
        };
    }

    /** Mendapatkan kelas badge Tailwind CSS sesuai status pesanan. */
    public function statusBadgeClass(): string
    {
        return match($this->status) {
            'delivered', 'selesai' => 'bg-emerald-500/10 text-emerald-700 border-emerald-500/20',
            default                => 'bg-amber-500/10 text-amber-700 border-amber-500/20',
        };
    }

    /** Memformat total harga pesanan ke mata uang Rupiah. */
    public function formattedTotal(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }
}
