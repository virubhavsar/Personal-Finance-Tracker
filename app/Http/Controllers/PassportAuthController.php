<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PassportAuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $token = $this->authService->register($request->validated());
        return response()->json(['token' => $token], 200);
    }

    public function login(LoginRequest $request)
    {
        $token = $this->authService->login($request->validated());

        if ($token) {
            $username = Auth::user()->username;
            $email = Auth::user()->email;
            return response()->json(['Username'=> $username,'Email'=> $email,'token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
