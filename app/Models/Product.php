<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'old_price',
        'size',
        'stock',
        'category',
        'image',
        'hover_image',
    ];
    /**
     * Transformer les tailles en tableau (accessor).
     */
    protected $casts = [
        'price' => 'float',
        'old_price' => 'float',
    ];

    public function getSizesAttribute($value)
    {
        return $value ? explode(', ', $value) : [];
    }
}
