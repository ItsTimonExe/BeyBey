<?php

        namespace App\Http\Controllers\Admin;

        use App\Models\Product;
        use App\Http\Controllers\Controller;
        use App\Models\Category;
        use Illuminate\Http\Request;
        use Inertia\Inertia;
        use Illuminate\Support\Str;

        class AdminProductController extends Controller
        {
            public function index()
            {
                $products = Product::with('category')->get();
                $categories = Category::all();

                return Inertia::render('Admin/Product/Index', [
                    'products' => $products,
                    'categories' => $categories
                ]);
            }

            public function store(Request $request)
            {
                $request->validate([
                    'name' => 'required|string|max:255',
                    'description' => 'required|string',
                    'price' => 'required|numeric',
                    'size' => 'nullable|string',
                    'stock' => 'required|integer',
                    'category_id' => 'required|integer|exists:categories,id',
                    'old_price' => 'nullable|numeric',
                    'image' => 'nullable|image',
                    'hover_image' => 'nullable|image',
                ]);

                $product = new Product;
                $product->name = $request->name;
                $product->description = $request->description;
                $product->price = $request->price;
                $product->size = $request->size;
                $product->stock = $request->stock;
                $product->category_id = $request->category_id;
                $product->old_price = $request->old_price;

                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('image'), $uniqueName);
                    $product->image = 'image/' . $uniqueName;
                }

                if ($request->hasFile('hover_image')) {
                    $hoverImage = $request->file('hover_image');
                    $uniqueName = time() . '-' . Str::random(10) . '.' . $hoverImage->getClientOriginalExtension();
                    $hoverImage->move(public_path('image'), $uniqueName);
                    $product->hover_image = 'image/' . $uniqueName;
                }

                $product->save();

                return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
            }

            public function update(Request $request, $id)
            {
                $request->validate([
                    'name' => 'required|string|max:255',
                    'description' => 'required|string',
                    'price' => 'required|numeric',
                    'size' => 'nullable|string',
                    'stock' => 'required|integer',
                    'category_id' => 'required|integer|exists:categories,id',
                    'old_price' => 'nullable|numeric',
                    'image' => 'nullable|image',
                    'hover_image' => 'nullable|image',
                ]);

                $product = Product::findOrFail($id);
                $product->name = $request->name;
                $product->description = $request->description;
                $product->price = $request->price;
                $product->size = $request->size;
                $product->stock = $request->stock;
                $product->category_id = $request->category_id;
                $product->old_price = $request->old_price;

                if ($request->hasFile('image')) {
                    if ($product->image && file_exists(public_path($product->image))) {
                        unlink(public_path($product->image));
                    }
                    $image = $request->file('image');
                    $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('image'), $uniqueName);
                    $product->image = 'image/' . $uniqueName;
                }

                if ($request->hasFile('hover_image')) {
                    if ($product->hover_image && file_exists(public_path($product->hover_image))) {
                        unlink(public_path($product->hover_image));
                    }
                    $hoverImage = $request->file('hover_image');
                    $uniqueName = time() . '-' . Str::random(10) . '.' . $hoverImage->getClientOriginalExtension();
                    $hoverImage->move(public_path('image'), $uniqueName);
                    $product->hover_image = 'image/' . $uniqueName;
                }

                $product->save();

                return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
            }

           public function destroy($id)
            {
                $product = Product::findOrFail($id);
                if ($product->image) {
                    if (file_exists(public_path($product->image))) {
                        unlink(public_path($product->image));
                    }
                }
                if ($product->hover_image) {
                    if (file_exists(public_path($product->hover_image))) {
                        unlink(public_path($product->hover_image));
                    }
                }
                $product->delete();

                return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
            }
        }
