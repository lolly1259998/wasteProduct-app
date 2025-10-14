<?php
// app/Models/Order.php
namespace App\Models;

use App\Enums\OrderStatus;
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
        'tracking_number',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'order_date' => 'datetime',
        'status' => OrderStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function calculateTotal()
    {
        $products = [
            1 => ['price' => 10.00],
            2 => ['price' => 15.00],
            3 => ['price' => 20.00],
        ];
        return $this->quantity * ($products[$this->product_id]['price'] ?? 0);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($order) {
            if ($order->quantity && isset($order->product_id)) {
                $order->total_amount = $order->calculateTotal();
            }
        });
    }
}