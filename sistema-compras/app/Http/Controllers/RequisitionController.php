<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requisition;
use App\Models\RequisitionProduct;
use App\Models\Product;
use App\Http\Requests\StoreRequisitionRequest;

class RequisitionController extends Controller
{
    public function index()
    {
        $requisitions = Requisition::with('products.product')->paginate(20);
        $products = Product::all(); // Fetch all products
        // For now, use solicitacao.blade.php as template
        return view('solicitacao', compact('requisitions', 'products')); // Pass products to the view
    }

    public function create()
    {
        $products = Product::all();
        $sectors = \App\Models\Sector::all();
        // Use solicitacao.blade.php as template for create
        return view('solicitacao', compact('products', 'sectors'));
    }

    public function store(StoreRequisitionRequest $request)
    {
        // Create a new requisition
        $requisition = Requisition::create($request->validated());

        // Attach products to the requisition
        foreach ($request->products as $product) {
            RequisitionProduct::create([
                'requisition_id' => $requisition->id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]);
        }

        return redirect()->route('requisitions.index')->with('success', 'Requisition created successfully.');
    }

    public function show($id)
    {
        $requisition = Requisition::with('products.product')->findOrFail($id);
        return view('requisitions.show', compact('requisition'));
    }
}
