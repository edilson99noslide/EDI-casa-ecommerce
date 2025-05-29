<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ValidateTwoFactorRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            '2fa_code' => 'required|string|size:6'
        ];
    }
}
