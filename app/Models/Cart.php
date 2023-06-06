<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cart extends Model
{
    protected $fillable = [
        'product_id',
        'stock_id',
        'user_id',
        'has_sizes',
        'size',
        'quantity'
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function product() : BelongsTo {
        return $this->belongsTo(Product::class);
    }

    public function stock() : BelongsTo {
        return $this->belongsTo(Stock::class);
    }

    public function order() : BelongsTo {
        return $this->belongsTo(Order::class);
    }
}
