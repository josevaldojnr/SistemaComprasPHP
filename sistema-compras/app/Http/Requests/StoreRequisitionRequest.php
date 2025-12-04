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
            'requestor_id' => 'nullable|integer|exists:users,id',
            'description' => 'nullable|string',
            'setor' => 'required|string|max:255',
            'products' => 'required|array|min:1',
            'products.*.produto_id' => 'required|integer|exists:produtos,id',
            'products.*.quantidade' => 'required|integer|min:1',
        ];
    }
}
