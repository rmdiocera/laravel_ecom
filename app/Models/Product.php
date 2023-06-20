<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'description',
        'price',
    ];

    public function stocks() : HasMany {
        return $this->hasMany(Stock::class);
    }

    public function orders() : HasMany {
        return $this->hasMany(Order::class);
    }

    public function images() : HasMany {
        return $this->hasMany(ProductImages::class);
    }

    public function scopeFilterProducts($query, $filters) {
        return $query->when($filters['brand_id'] ?? false, fn($query, $value) => 
            $query->where('brand_id', $value)
        )->when($filters['category_id'] ?? false, fn($query, $value) => 
            $query->where('category_id', $value)
        )->when($filters['price_from'] ?? false, fn($query, $value) => 
            $query->where('price', '>=', $value)
        )->when($filters['price_to'] ?? false, fn($query, $value) => 
        $query->where('price', '<=', $value)
        );
    }
}
