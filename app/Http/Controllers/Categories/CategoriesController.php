<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    // Show Add Category Form
    public function create()
    {
        return view('Pages.Categories.Add_Categories');
    }

    // Store New Category
    public function store(Request $request)
    {
        $userId = \Illuminate\Support\Facades\Auth::user()->admin_id ?? \Illuminate\Support\Facades\Auth::id();
        $request->validate([
            'name' => [
                'required',
                \Illuminate\Validation\Rule::unique('categories')->where('user_id', $userId)
            ],
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg,webp|max:5120'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'cloudinary');
        }

        Category::create($data);
        return redirect()->route('category.index')->with('success', 'Category added successfully!');
    }

    // Show Edit Category Form
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('Pages.Categories.Update_Categories', compact('category'));
    }

    // Update Category
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $userId = \Illuminate\Support\Facades\Auth::user()->admin_id ?? \Illuminate\Support\Facades\Auth::id();
        $request->validate([
            'name' => [
                'required',
                \Illuminate\Validation\Rule::unique('categories')->where('user_id', $userId)->ignore($category->id)
            ],
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg,webp|max:5120'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'cloudinary');
        }

        $category->update($data);
        return redirect()->route('category.index')->with('success', 'Category updated successfully!');
    }

    // Delete Category
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category deleted successfully!');
    }
}
