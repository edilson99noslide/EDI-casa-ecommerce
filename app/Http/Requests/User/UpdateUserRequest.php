<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest {
    public function rules(): array {
        return [
            'name'     => 'sometimes|string|max:100|required',
            'email'    => 'sometimes|email|unique:users,email' . $this->route('user'),
            'password' => 'sometimes|string|min:6|confirmed',
        ];
    }
}
