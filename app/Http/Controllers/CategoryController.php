<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Display all categories or search results
    public function index(Request $request)
    {
        $search = $request->input('search');  // Get the search term from the request

        // If there's a search term, filter the categories by name, else get all categories
        $categories = Category::when($search, function($query) use ($search) {
            return $query->where('name', 'like', "%{$search}%");  // Filter by category name
        })->get();

        return view('categories.index', compact('categories'));  // Return the view with categories
    }

    // Show the form to create a new category
    public function create()
    {
        return view('categories.create');
    }

    // Store a new category in the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'categorie_name' => 'required|string|max:255',  // Validate the category name
        ]);

        Category::create([
            'name' => $validated['categorie_name'],  // Store the new category
        ]);

        return redirect()->route('categories.index')->with('msg', 'Category added successfully!');
    }

    // Edit the category (if needed)
    public function edit($id)
    {
        $category = Category::findOrFail($id);  // Find category by ID
        return view('categories.edit', compact('category'));
    }

    // Update the category data
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'categorie_name' => 'required|string|max:255',  // Validate the category name
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $validated['categorie_name'],
        ]);

        return redirect()->route('categories.index')->with('msg', 'Category updated successfully!');
    }

    // Delete a category
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('msg', 'Category deleted successfully!');
    }
}
