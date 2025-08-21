<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

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
        $fields = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role_id' => 'required|exists:roles,id', 
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        $role = Role::findOrFail($fields['role_id']);
        $user->assignRole($role->name);

        return response()->json($user->load('roles'), 201);
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
