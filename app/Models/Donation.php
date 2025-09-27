<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'waste_id',
        'item_name',
        'condition',
        'status',
        'description',
        'images',
        'pickup_required',
        'pickup_address'
    ];

    protected $casts = [
        'images' => 'array',
        'pickup_required' => 'boolean',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function waste()
    {
        return $this->belongsTo(Waste::class);
    }

    // Scopes pour différents statuts
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeClaimed($query)
    {
        return $query->where('status', 'claimed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}