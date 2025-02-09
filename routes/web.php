<?php
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminContact;
use App\Http\Controllers\Admin\AdminCategories;
use App\Http\Controllers\Admin\AdminSpecialOffers;
use App\Http\Controllers\Admin\AdminUsers;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;



Route::post('/contact', [ContactController::class, 'store']);
Route::get('/products', [ProductController::class, 'index']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/product/{id}/related', [ProductController::class, 'getRelatedProducts']);
});
Route::fallback(function () {
    return Inertia::render('NotFound'); // Affiche un composant Vue spécifique pour les erreurs 404
});
Route::get('/product/{id}', function ($id) {
    return Inertia::render('product', [
        'productId' => $id, // Example of passing the productId as a prop
    ]);
})->name('product.show');

Route::get('/cart', function () {
    return Inertia::render('cart');
})->name('cart');

Route::get('/shop', function () {
    return Inertia::render('shop');
})->name('shop');

// Page Contact
Route::get('/contact', function () {
    return Inertia::render('contact');
})->name('contact');

Route::get('/', function () {
    return Inertia::render('home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Admin routes

Route::group(['prefix' => 'admin', 'middleware' => 'redirectAdmin'], function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    //products routes
    Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::post('/products/store',[AdminProductController::class,'store'])->name('admin.products.store');
    Route::put('/products/update/{id}',[AdminProductController::class,'update'])->name('admin.products.update');
    Route::delete('/admin/products/{id}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');

    // Special Offers routes
    Route::get('/special_offers', [AdminSpecialOffers::class, 'index'])->name('admin.special_offers.index');
    Route::post('/special_offers', [AdminSpecialOffers::class, 'store'])->name('admin.special_offers.store');
    Route::put('/special_offers/{id}', [AdminSpecialOffers::class, 'update'])->name('admin.special_offers.update');
    Route::delete('/special_offers/{id}', [AdminSpecialOffers::class, 'destroy'])->name('admin.special_offers.destroy');
    //Users routes
    Route::get('/users', [AdminUsers::class, 'index'])->name('admin.users.index');
    //Orders routes

    //Categories routes
        Route::get('/categories', [AdminCategories::class, 'index'])->name('admin.categories.index');
        Route::post('/categories', [AdminCategories::class, 'storeOrUpdate'])->name('admin.categories.store');
        Route::put('/categories/{id}', [AdminCategories::class, 'storeOrUpdate'])->name('admin.categories.update');
        Route::delete('/categories/{id}', [AdminCategories::class, 'destroy'])->name('admin.categories.destroy');
    // contact routes
    Route::get('/contacts', [AdminContact::class, 'index'])->name('admin.contacts.index');
    Route::get('/contacts/{id}', [AdminContact::class, 'show'])->name('admin.contacts.show');
    Route::post('/contacts', [AdminContact::class, 'store'])->name('admin.contacts.store');
    Route::put('/contacts/{id}', [AdminContact::class, 'update'])->name('admin.contacts.update');
    Route::delete('/contacts/{id}', [AdminContact::class, 'destroy'])->name('admin.contacts.destroy');



});

//end
require __DIR__.'/auth.php';
