<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'carts'; // Specify the correct table name
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'name',
        'size',
        'quantity',
        'price',
    ];
}
