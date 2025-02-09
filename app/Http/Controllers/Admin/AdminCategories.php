<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class AdminCategories extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return inertia('Admin/Categories/Index', ['categories' => $categories]);
    }

    public function storeOrUpdate(Request $request, $id = null)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ]);

        if ($id) {
            $category = Category::findOrFail($id);
            $category->name = $request->name;
            $category->save();
            $message = 'Category updated successfully.';
        } else {
            Category::create($request->all());
            $message = 'Category created successfully.';
        }

        return redirect()->route('admin.categories.index')->with('success', $message);
    }

    public function destroy($id)
    {
        Category::destroy($id);
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
