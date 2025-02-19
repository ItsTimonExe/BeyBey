<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'address',
        'city',
        'zip_code',
        'phone',
        'payment_method',
        'total',
        'size',
        'name',
        'quantity',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
