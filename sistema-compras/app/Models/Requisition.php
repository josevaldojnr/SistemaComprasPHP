<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Requisition extends Model
{
    protected $table = 'requisicao';

    protected $fillable = [
        'requestor_id',
        'pricing_id',
        'buyer_id',
        'manager_id',
        'description',
        'total_cost',
        'setor',
        'status_id',
    ];

    protected $casts = [
        'total_cost' => 'decimal:2',
        'status_id' => 'integer',
    ];

    public function products()
    {
        return $this->hasMany(RequisitionProduct::class, 'requisicao_id');
    }

    public function requestor()
    {
        return $this->belongsTo(User::class, 'requestor_id');
    }

    public function pricing()
    {
        return $this->belongsTo(User::class, 'pricing_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function store(Request $request)
    {
        $requisition = Requisition::create([
            'setor' => $request->input('setor_id'), // or map to setor_id if you change the schema
            'description' => $request->input('descricao'),
            // add other fields as needed
        ]);

        $products = json_decode($request->input('products_json'), true);
        if (is_array($products)) {
            foreach ($products as $product) {
                RequisitionProduct::create([
                    'requisicao_id' => $requisition->id,
                    'produto_id' => $product['id'],
                    'quantidade' => $product['quantity'],
                    'subtotal' => $product['price'] * $product['quantity'],
                ]);
            }
        }

        return redirect()->route('requisitions.index')->with('success', 'Requisition created successfully.');
    }
}
