<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'email' => 'required|string|email|max:255|exists:users,email',
        ];
    }

    public function messages(): array {
        return [
            'email.require' => 'O campo e-mail é obrigatorio.',
            'email.email'   => 'Informe um e-mail valido.',
            'email.exists'  => 'Não existe nenhum usuário com este e-mail.',
        ];
    }
}
