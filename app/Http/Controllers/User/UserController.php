<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

// Form Request
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

// Use cases
use App\UseCases\User\GetAllUsersUseCase;
use App\UseCases\User\GetUserUseCase;
use App\UseCases\User\CreateUserUseCase;
use App\UseCases\User\UpdateUserUseCase;
use App\UseCases\User\DeleteUserUseCase;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller {
    public function __construct(
        private GetAllUsersUseCase $getAllUsersUseCase,
        private GetUserUseCase $getUserUseCase,
        private UpdateUserUseCase $updateUserUseCase,
        private CreateUserUseCase $createUserUseCase,
        private DeleteUserUseCase $deleteUserUseCase,
    ) {}

    public function index() {
        $users = $this->getAllUsersUseCase->handle();

        return response()->json([
            'success' => true,
            'message' => 'Usuários retornados com sucesso.',
            'data' => $users,
        ]);
    }

    /**
     * Responsável por retornar um usuário pelo Id
     *
     * @param int $userId
     * @return JsonResponse
     */
    public function show(int $userId) {
        $user = $this->getUserUseCase->handle($userId);

        if(!$user)
            return response()->json([
                'success' => false,
                'message' => 'Usuário não encontrado.'
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Usuário encontrado com sucesso.',
            'data' => $user
        ]);
    }

    /**
     * Responsável por cadastrar um usuário
     *
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function store(CreateUserRequest $request): JsonResponse {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);

        $user = $this->createUserUseCase->handle($data);

        return response()->json([
            'success' => true,
            'message' => 'Usuário criado com sucesso!',
            'data' => $user
        ], 201);
    }

    /**
     * Responsável por atualizar as informações de um usuário
     *
     * @param UpdateUserRequest $request
     * @param int $userId
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, int $userId): JsonResponse {
        $user = $this->updateUserUseCase->handle($userId, $request->validated());

        if(!$user)
            return response()->json([
                'success' => false,
                'message' => 'Usuário não encontrado.'
            ], 404);

        return response()->json([
            'success' => true,
            'message' => 'Usuário atualizado com sucesso.',
            'data' => $user,
        ]);
    }

    /**
     * Responsável por remover um usuário
     *
     * @param int $userId
     * @return JsonResponse|Response
     */
    public function destroy(int $userId): JsonResponse|Response {
        $user = $this->deleteUserUseCase->handle($userId);

        if(!$user)
            return response()->json([
                'success' => false,
                'message' => 'Usuário não encontrado.'
            ], 404);

        return response()->noContent();
    }
}
