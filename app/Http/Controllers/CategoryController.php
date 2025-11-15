<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('category', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|max:50'
        ]);

        Category::create($request->all());

        return redirect()->route('category.index')->with('success', 'Categoría creada');
    }

    public function update(Request $request, $id)
    {
        $cat = Category::findOrFail($id);

        $request->validate([
            'category' => 'required|max:50'
        ]);

        $cat->update($request->all());

        return redirect()->route('category.index')->with('success', 'Categoría actualizada');
    }

    public function destroy($id)
    {
        Category::destroy($id);
        return redirect()->route('category.index')->with('success', 'Categoría eliminada');
    }
}
