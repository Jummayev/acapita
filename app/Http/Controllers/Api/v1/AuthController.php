<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\AuthInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(public AuthInterface $authRepository)
    {
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        return $this->authRepository->login($request);

    }

    public function getMe(Request $request)
    {
        $user = Auth::user();
        if ($request->filled('include')) {
            $user = $user->load(explode(',', $request->get('include')));
        }
        if ($request->filled('append')) {
            $user = $user->append(explode(',', $request->get('append')));
        }

        return okResponse([
            'user' => $user,
            'token' => $request->bearerToken(),
        ]);
    }

    public function logout(Request $request)
    {
        return $this->authRepository->logout();
    }

    public function updateMe(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'login' => 'required|string',
            'password' => 'nullable|min:8',
            'file_id' => 'nullable|integer|exists:files,id',
        ]);

        return $this->authRepository->updateMe($request);
    }
}
