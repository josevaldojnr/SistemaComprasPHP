<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categoria', compact('categories'));
    }

    public function create()
    {
        return view('categoria');
    }

    public function store(Request $request)
    {
        $request->validate(['nome' => 'required|string|max:255']);
        Category::create($request->only('nome'));
        return redirect()->route('categories.index');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categoria', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->only('nome'));
        return redirect()->route('categories.index');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index');
    }
}