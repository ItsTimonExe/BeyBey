<?php

    namespace App\Http\Controllers;

    use App\Models\CartItem;
    use App\Models\Product;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;

    class CartController extends Controller
    {
        public function addToCart(Request $request)
        {
            \Log::info('Add to Cart Request:', $request->all());

            $product = Product::find($request->product_id);
            if (!$product) {
                \Log::error('Product not found', ['product_id' => $request->product_id]);
                return response()->json(['message' => 'Product not found'], 404);
            }

            try {
                $cartItem = new CartItem();
                $cartItem->product_id = $product->id;
                $cartItem->name = $product->name;
                $cartItem->size = $request->size;
                $cartItem->quantity = $request->quantity;
                $cartItem->price = $product->price;

                if (Auth::check()) {
                    $cartItem->user_id = Auth::id();
                    $cartItem->save();
                } else {
                    $cart = Session::get('cart', []);
                    $cart[] = $cartItem;
                    Session::put('cart', $cart);
                }

                \Log::info('Product added to cart successfully', ['cartItem' => $cartItem]);
                return response()->json(['message' => 'Product added to cart successfully']);
            } catch (\Exception $e) {
                \Log::error('Error adding product to cart', ['error' => $e->getMessage()]);
                return response()->json(['message' => 'Failed to add product to cart'], 500);
            }
        }

        public function getCart()
        {
            if (Auth::check()) {
                $cartItems = CartItem::where('user_id', Auth::id())->get();
            } else {
                $cartItems = Session::get('cart', []);
            }

            return response()->json($cartItems);
        }


public function removeFromCart($product_id)
{
    try {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->where('product_id', $product_id)->delete();
        } else {
            $cart = Session::get('cart', []);
            $cart = array_filter($cart, function($item) use ($product_id) {
                return $item['product_id'] != $product_id; // Use loose comparison
            });
            Session::put('cart', array_values($cart)); // Reindex the array
        }

        return response()->json(['message' => 'Product removed from cart successfully']);
    } catch (\Exception $e) {
        \Log::error('Error removing product from cart', ['error' => $e->getMessage()]);
        return response()->json(['message' => 'Failed to remove product from cart'], 500);
    }
}
    }
