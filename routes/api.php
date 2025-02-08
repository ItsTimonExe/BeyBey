<?php
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SpecialOfferController;
use App\Http\Controllers\CartController;



Route::get('/product/{id}/related', [ProductController::class, 'getRelatedProducts']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/product/{id}', [ProductController::class, 'getProductById']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/cart/add', [CartController::class, 'addToCart']);
});

Route::get('/debug/auth', function (Request $request) {
    return response()->json([
        'authenticated' => auth()->check(),
        'user' => auth()->user(),
        'cookies' => $request->cookies->all(),
        'headers' => $request->headers->all(),
    ]);
})->middleware('auth:sanctum');
Route::middleware(['auth:sanctum'])->post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Déconnexion réussie.']);
});

Route::get('/special-offers', [SpecialOfferController::class, 'index']);
Route::get('/last-products', [ProductController::class, 'getLastProducts']);
Route::get('/products' , [ProductController::class , 'index']);
Route::get('/categories', [CategoryController::class, 'index']);                       // Lire toutes les catégories
Route::post('/categories', [CategoryController::class, 'store']);                     // Créer une catégorie
Route::get('/categories/{id}', [CategoryController::class, 'show']);                 // Lire une catégorie spécifique
Route::put('/categories/{id}', [CategoryController::class, 'update']);              // Modifier une catégorie
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);         // Supprimer une catégorie

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
