<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
