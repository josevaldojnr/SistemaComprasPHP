<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'produtos';
    protected $fillable = [
        'nome',
        'preco',
        'categoria_id',
    ];
    
    public function categoria()
    {
        return $this->belongsTo(Category::class, 'categoria_id');
    }

    public function requisitionProducts()
    {
        return $this->hasMany(RequisitionProduct::class, 'produto_id');
    }
    
}
