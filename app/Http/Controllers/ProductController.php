<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Afficher tous les produits
    public function index()
    {
        $products = Product::with('category')->get();
        return response()->json($products);
    }

    // Formulaire pour créer un produit
    public function create()
    {
        return view('products.create');
    }

    // Enregistrer un produit
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'size' => 'required|string',
            'stock' => 'required|integer',
            'category' => 'required|string',
        ]);

        Product::create($request->all());
        return redirect()->route('products.index')->with('success', 'Produit ajouté avec succès.');
    }

    // Afficher un produit spécifique

    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            abort(404, 'Product not found.');
        }

        return view('products.show', [
            'product' => $product
        ]);
    }

    // Formulaire pour modifier un produit
    public function edit(Product $product)
    {
        return view('products.edit', compact('product')); // Vue: resources/views/products/edit.blade.php
    }

    // Mettre à jour un produit
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'size' => 'required|string',
            'stock' => 'required|integer',
            'category' => 'required|string',
        ]);

        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'Produit mis à jour avec succès.');
    }

    // Supprimer un produit
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produit supprimé avec succès.');
    }

    public function getLastProducts()
    {

        $products = Product::orderBy('id', 'desc')
        ->take(8) // Limiter à 8 produits
        ->get();

        return response()->json($products);
    }
    public function getProductById($id)
    {
        $product = Product::find($id); // Récupérer le produit avec l'ID donné
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404); // Si non trouvé
        }
        return response()->json($product); // Retourner les données du produit
    }
    public function getRelatedProducts($id)
    {
        // Rechercher le produit par ID
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Produit non trouvé.'], 404);
        }

        // Trouver des produits similaires (exemple basé sur une catégorie)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id) // Exclure le produit actuel
            ->limit(4) // Limiter à 4 produits
            ->get();

        return response()->json($relatedProducts);
    }
}
