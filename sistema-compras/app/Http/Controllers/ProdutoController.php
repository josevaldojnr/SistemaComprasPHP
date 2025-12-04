<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produtos = Product::paginate(20);
    // You may need to also pass $categorias and $itens if used in the view
    $categorias = \App\Models\Category::all();
    $itens = Product::with('categoria')->get();
    return view('itens', compact('itens', 'categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated());
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produto = Product::findOrFail($id);
        return view('products.show', compact('produto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $produto = Product::findOrFail($id);
        return view('products.edit', compact('produto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $produto = Product::findOrFail($id);
        $produto->update($request->only(['nome', 'preco', 'categoria_id']));
        return redirect()->route('products.show', $produto->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produto = Product::findOrFail($id);
        $produto->delete();
        return redirect()->route('products.index');
    }
}
