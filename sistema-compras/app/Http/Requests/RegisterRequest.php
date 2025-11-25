<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required|string|min:4',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed', // espera campo password_confirmation
        ];
    }

    public function messages()
    {
        return [
            'password.confirmed' => 'As senhas não coincidem.',
            'username.min' => 'Nome de usuário deve ter pelo menos 4 caracteres.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
        ];
    }
}
