<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $table = 'setores';

    protected $fillable = [
        'nome',
        'user_responsavel_id',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'setor_id');
    }

    public function responsavel()
    {
        return $this->belongsTo(User::class, 'user_responsavel_id');
    }
}
