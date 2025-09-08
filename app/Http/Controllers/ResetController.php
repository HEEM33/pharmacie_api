<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\UserMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetController extends Controller
{
     public function reset(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $fields['email'])->first();
        $password = Str::random(10);
        $user->password = Hash::make($password);
        $user->save();
         Mail::to($user->email)->send(new UserMail($user, $password));
        return response()->json([
            'message' => 'Mot de passe réinitialisé avec succès',
        ], 200);
    }

    public function newpassword(Request $request){
         $request->validate([
            'email' => 'required|email',
            'ancienpassword' => 'required',
            'password' => 'required|min:6|confirmed', 
        ], [
            'email.required' => 'L’adresse email est obligatoire',
            'email.email' => 'Format de l’adresse email invalide',
            'email.exists' => 'Aucun utilisateur trouvé avec cette adresse email',
            'password.required' => 'Le mot de passe est obligatoire',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères',
            'password.confirmed' => 'La confirmation ne correspond pas',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Utilisateur introuvable'], 404);
        }

        if (!Hash::check($request->ancienpassword, $user->password)) {
            return response()->json(['message' => 'Ancien mot de passe incorrect'], 400);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Mot de passe changé avec succès'], 200);
    }
}
