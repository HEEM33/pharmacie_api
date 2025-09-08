<?php

namespace App\Http\Controllers;

use App\Mail\UserCreatedMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;


class UserController extends Controller
{
    /**
     * Afficher tous les utilisateurs avec leurs rôles.
     */
    public function index()
    {
        $users = User::with('roles')->get();
        return response()->json($users, 200);
    }

    /**
     * Créer un nouvel utilisateur et lui assigner un rôle.
     */
    public function store(Request $request)
    {
        try{
        $fields = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'role_id' => 'required|exists:roles,id', 
        ]);
        $password = Str::random(10);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($password),
        ]);
        $role = Role::findOrFail($fields['role_id']);
        $user->assignRole($role->name);

         Mail::to($user->email)->send(new UserCreatedMail($user, $password));

        return response()->json($user->load('roles'), 201);
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


    /**
     * Afficher un utilisateur spécifique avec ses rôles.
     */
    public function show(string $id)
    {
        $user = User::with('roles')->findOrFail($id);
        return response()->json(['user' => $user], 200);
    }

    /**
     * Mettre à jour un utilisateur (optionnel).
     */
    public function update(Request $request, string $id)
    {
        try{
        $user = User::findOrFail($id);

        $fields = $request->validate([
            'name' => 'sometimes|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|min:6',
            'role_id' => 'sometimes|exists:roles,id',
        ]);

        $user->update([
            'name' => $fields['name'] ?? $user->name,
            'email' => $fields['email'] ?? $user->email,
        ]);

        if (isset($fields['role_id'])) {
            $role = Role::findOrFail($fields['role_id']);
            $user->syncRoles([$role->name]); 
        }

        return response()->json($user->load('roles'), 200);
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

    /**
     * Supprimer un utilisateur.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Utilisateur supprimé avec succès'], 200);
    }
}
