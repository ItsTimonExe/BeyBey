<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialOffer extends Model
{
    protected $table = 'special_offers';

    // Champs autorisés pour les opérations de masse
    protected $fillable = ['title', 'description', 'image'];
}
