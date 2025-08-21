<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    

    public function login (Request $request){
         $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Identifiants invalide'], 401);
        }

        $token = $user->createToken($user->name)->plainTextToken;
return [
    'user'=> $user,
    'access_token' => $token,
    'token_type' => 'Bearer'
];

    } 

    public function logout (Request $request){
         $request->user()->tokens()->delete();
        return ['message' => 'Successfully logged out'];
    }
}
