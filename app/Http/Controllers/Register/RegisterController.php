<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Responsável por criar um usuário
     *
     * @param Request $request
     * @return JsonResponse Resposta em JON com o status da operação
     */
    public function register(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'message' => 'Usuário registrado com sucesso!',
            'data'    => ['user' => $user],
        ], 201);
    }
}
