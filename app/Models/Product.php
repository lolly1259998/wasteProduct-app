<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_quantity',
        'waste_category_id',
        'recycling_process_id',
        'image_path',
        'specifications',
        'is_available'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'specifications' => 'array',
        'is_available' => 'boolean',
    ];

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)
                    ->where('stock_quantity', '>', 0);
    }

    public function decrementStock($quantity = 1)
    {
        $this->decrement('stock_quantity', $quantity);
        
        if ($this->stock_quantity <= 0) {
            $this->update(['is_available' => false]);
        }
    }
}