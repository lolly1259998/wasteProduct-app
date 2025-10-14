<?php

namespace App\Models;

use App\Enums\ReservationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'reserved_until',
        'status',
    ];

    protected $casts = [
        'reserved_until' => 'datetime',
        'status' => ReservationStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}