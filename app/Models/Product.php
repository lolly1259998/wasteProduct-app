<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
protected $name='Product';
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_quantity',
        'waste_category_id',
        'category_id',
        'user_id',
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

    // Relations
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function wasteCategory()
    {
        return $this->belongsTo(WasteCategory::class, 'waste_category_id');
    }

    public function recyclingProcess()
    {
        return $this->belongsTo(RecyclingProcess::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope pour les produits disponibles
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)
                    ->where('stock_quantity', '>', 0);
    }

    // Méthode pour décrémenter le stock
    public function decrementStock($quantity = 1)
    {
        $this->decrement('stock_quantity', $quantity);
        
        if ($this->stock_quantity <= 0) {
            $this->update(['is_available' => false]);
        }
    }
}