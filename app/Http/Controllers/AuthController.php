<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = auth('api')->user();  
        $userId = $user->id;  
        return $this->respondWithToken($token,$userId);
    }


    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }


    public function refresh()
    {
        $newToken = auth('api')->refresh();
        $user = auth('api')->user(); // Get the authenticated user
        $userId = $user->id; // Get the user ID
        return $this->respondWithToken($newToken, $userId);
    }
    

    protected function respondWithToken($token,$userId)
    {
        return response()->json([
            'access_token' => $token,
            'user_id' => $userId, 
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

}