<?php

namespace App\Http\Controllers;
use App\Models\SpecialOffer;
use Illuminate\Http\Request;

class SpecialOfferController extends Controller
{
    public function index()
    {
        return response()->json(SpecialOffer::all());
    }
}
