<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'size',
    ];

    public function product() : BelongsTo {
        return $this->belongsTo(Product::class);
    }
}
