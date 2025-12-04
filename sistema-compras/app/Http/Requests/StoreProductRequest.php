<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
            'categoria_id' => 'required|integer|exists:categorias,id',
        ];
    }
}
