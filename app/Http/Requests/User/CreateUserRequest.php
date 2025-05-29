<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name'                  => 'required|string|max:100|min:3',
            'email'                 => 'required|string|email|max:100|unique:users,email' . $this->route('user'),
            'password'              => 'required|string|confirmed|min:8',
            'password_confirmation' => 'required|string|same:password',
        ];
    }
}
