<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImages extends Model
{
    protected $fillable = ['filename'];
    protected $appends = ['src'];

    public function listing(): BelongsTo {
        return $this->belongsTo(Product::class);
    }

    public function getSrcAttribute() {
        return asset("storage/{$this->filename}");
    }
}
