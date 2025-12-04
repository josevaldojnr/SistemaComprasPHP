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
        $requisitions = Requisition::with('products.product')->paginate(10);
        return view('minhassolicitacoes', compact('requisitions'));
    }

    public function create()
    {
        $products = Product::all();
        $sectors = \App\Models\Sector::all();
      
        return view('solicitacao', compact('products', 'sectors'));
    }

    public function store(StoreRequisitionRequest $request)
    {
        // Step 1: Create and save the requisition
        $requisition = Requisition::create([
            'setor' => $request->input('setor_id'),
            'description' => $request->input('descricao'),
        ]);

        // Step 2: Decode the products JSON
        $productsJson = $request->input('products_json');
        $products = json_decode($productsJson, true);

        // Step 3: Create requisicao_produtos using the new requisition ID
        if (is_array($products)) {
            foreach ($products as $product) {
                RequisitionProduct::create([
                    'requisicao_id' => $requisition->id,
                    'produto_id' => (int)$product['id'],
                    'quantidade' => (int)$product['quantity'],
                    'subtotal' => (float)$product['price'] * (int)$product['quantity'],
                ]);
            }
        }

        return redirect()->route('requisitions.index')->with('success', 'Requisition created successfully.');
    }

    public function show($id)
    {
        $requisition = Requisition::with('products.product')->findOrFail($id);
        return view('requisicoes.show', compact('requisition'));
    }

    public function updateStatus($id)
    {
        $requisition = Requisition::findOrFail($id);
        
        // Cycle through statuses: 1 (Pendente) -> 2 (Aprovada) -> 3 (Concluída) -> 1 (Pendente)
        $currentStatus = $requisition->status_id ?? 1;
        $nextStatus = ($currentStatus == 3) ? 1 : $currentStatus + 1;
        
        $requisition->update(['status_id' => $nextStatus]);
        
        return redirect()->route('requisitions.index')->with('success', 'Status atualizado com sucesso.');
    }
}