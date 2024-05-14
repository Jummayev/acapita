<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\AuthInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * @generated
 */
class AuthRepository extends BaseRepository implements AuthInterface
{
    public function login(Request $request): JsonResponse
    {
        if (Auth::guard('web')->attempt(['login' => $request->get('username'), 'password' => $request->get('password')])) {
            $user = Auth::user();
            if ($user->role === User::ROLE_ADMIN) {
                $token = $user->createToken($user->name, [User::ROLE_ADMIN])->accessToken;
            } else {
                return errorResponse('Invalid credentials', ['message' => 'User is not admin'], 401);
            }

            return okResponse([
                'user' => $user,
                'token' => $token,
            ]);
        } else {
            return errorResponse('Invalid credentials', ['message' => 'Username or password is incorrect'], 401);
        }
    }

    public function logout(): JsonResponse
    {
        $user = Auth::user();
        $user->tokens()->delete();

        return okResponse($user);
    }

    public function updateMe(Request $request): JsonResponse
    {
        $user = Auth::user();
        $data = $request->only('name', 'login', 'password', 'email', 'file_id');
        if (! empty($data['password'])) {
            $data['password'] = Hash::make($request->get('password'));
        } else {
            unset($data['password']);
        }
        $user->update($data);
        $this->defaultAppendAndInclude($user, $request);

        return okResponse($user);
    }
}
