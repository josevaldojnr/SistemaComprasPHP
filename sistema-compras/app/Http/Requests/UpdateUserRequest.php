<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        // Você pode adicionar checagem de permissão aqui
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|integer|exists:users,id',
            'nome' => 'required|string|min:4',
            'email' => 'required|email',
            'funcao' => 'required|integer',
            'setor_id' => 'nullable|integer|exists:setores,id',
            'status' => 'required|in:ativo,inativo',
        ];
    }
}
