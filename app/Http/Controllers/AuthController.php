<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    

    public function login (Request $request){
        try{
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
    'token_type' => 'Bearer',
    'roles' => $user->getRoleNames(),
];
 } catch (ValidationException $e) {
        return response()->json([
            'message' => 'Erreur de validation',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Une erreur est survenue',
            'error' => $e->getMessage()
        ], 500);
    }

    } 

    public function logout (Request $request){
         $request->user()->tokens()->delete();
        return ['message' => 'Successfully logged out'];
    }
}
