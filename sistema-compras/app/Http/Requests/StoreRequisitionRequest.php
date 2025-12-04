<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequisitionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'setor_id' => 'required|string',
            'descricao' => 'nullable|string',
            'products_json' => 'required|string',
        ];
    }
}
