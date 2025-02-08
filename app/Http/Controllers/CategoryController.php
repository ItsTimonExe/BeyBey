<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;


class CategoryController extends Controller
{
    public function index()
    {
        // Retourner les catégories avec le nombre de produits
        $categories = Category::withCount('products')->get();
        return response()->json($categories);
    }


}
