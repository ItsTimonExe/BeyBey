<?php

            namespace App\Http\Controllers;

            use App\Models\Command;
            use Illuminate\Http\Request;
            use Illuminate\Support\Facades\Auth;
            use Illuminate\Support\Facades\Log;

            class CheckoutController extends Controller
            {
                public function placeOrder(Request $request)
                {
                    try {
                        $validated = $request->validate([
                            'userInfo.fullName' => 'required|string|max:255',
                            'userInfo.email' => 'required|email|max:255',
                            'userInfo.address' => 'required|string|max:255',
                            'userInfo.city' => 'required|string|max:255',
                            'userInfo.zipCode' => 'required|string|max:10',
                            'userInfo.phone' => 'required|string|max:15',
                            'userInfo.paymentMethod' => 'required|string|max:50',
                            'cartItems' => 'required|array',
                            'total' => 'required|numeric',
                        ]);

                        foreach ($validated['cartItems'] as $item) {
                            $command = new Command();
                            $command->user_id = Auth::id();
                            $command->full_name = $validated['userInfo']['fullName'];
                            $command->email = $validated['userInfo']['email'];
                            $command->address = $validated['userInfo']['address'];
                            $command->city = $validated['userInfo']['city'];
                            $command->zip_code = $validated['userInfo']['zipCode'];
                            $command->phone = $validated['userInfo']['phone'];
                            $command->payment_method = $validated['userInfo']['paymentMethod'];
                            $command->total = $validated['total'];
                            $command->size = $item['size'] ?? null;
                            $command->name = $item['name'];
                            $command->quantity = $item['quantity'];
                            $command->save();
                        }

                        return response()->json(['message' => 'Order placed successfully']);
                    } catch (\Exception $e) {
                        Log::error('Error placing order', ['error' => $e->getMessage()]);
                        return response()->json(['message' => 'Failed to place order'], 500);
                    }
                }
            }
