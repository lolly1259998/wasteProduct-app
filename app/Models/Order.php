<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'total_amount',
        'status',
        'order_date',
        'shipping_address',
        'payment_method',
        'tracking_number'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'order_date' => 'datetime',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Méthode pour calculer le total
    public function calculateTotal()
    {
        return $this->quantity * $this->product->price;
    }

    // Événement model pour calculer automatiquement le total
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($order) {
            if ($order->product && $order->quantity) {
                $order->total_amount = $order->calculateTotal();
            }
        });
    }
}