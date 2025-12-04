<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequisitionProduct extends Model
{
    protected $table = 'requisicao_produtos';

    protected $fillable = [
        'requisicao_id',
        'produto_id',
        'quantidade',
        'subtotal',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'quantidade' => 'integer',
    ];

    public function requisition()
    {
        return $this->belongsTo(Requisition::class, 'requisicao_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'produto_id');
    }
}
