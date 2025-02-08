<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Add to cart
    public function addToCart(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string',
        ]);

        $cartItem = CartItem::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'size' => $request->size,
            ],
            [
                'quantity' => $request->quantity,
                'price' => $request->price,
                'name' => $request->name,
            ]
        );

        return response()->json(['message' => 'Product added to cart!', 'cart_item' => $cartItem]);
    }

    // Remove from cart
    public function removeFromCart($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $cartItem = CartItem::where('user_id', Auth::id())->findOrFail($id);
        $cartItem->delete();

        return response()->json(['message' => 'Item removed from cart']);
    }

    // Get cart
    public function getCart()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $cart = CartItem::where('user_id', Auth::id())->get();
        return response()->json(['cart' => $cart]);
    }

    // Cart count
    public function cartCount()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');
        return response()->json(['cart_count' => $cartCount]);
    }
}
