<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
<<<<<<< HEAD
use App\Http\Controllers\Controller; 

class UserController extends Controller
{
=======
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Liste tous les utilisateurs (API / back-office)
     */
>>>>>>> 1d2df3b6af493b7c8db15c210051e591d249e98c
    public function index()
    {
        $users = User::with('role')->get();
        return response()->json($users);
    }

<<<<<<< HEAD
=======
    /**
     * Crée un nouvel utilisateur
     */
>>>>>>> 1d2df3b6af493b7c8db15c210051e591d249e98c
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role_id' => 'nullable|exists:roles,id',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        return response()->json(['message' => 'Utilisateur créé avec succès', 'user' => $user]);
    }

<<<<<<< HEAD
=======
    /**
     * Affiche un utilisateur spécifique
     */
>>>>>>> 1d2df3b6af493b7c8db15c210051e591d249e98c
    public function show($id)
    {
        $user = User::with('role')->findOrFail($id);
        return response()->json($user);
    }

<<<<<<< HEAD
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,'.$id,
            'password' => 'sometimes|min:6',
=======
    /**
     * Met à jour un utilisateur (API / back-office ou front-office)
     */
    public function update(Request $request, $id = null)
    {
        $user = $id ? User::findOrFail($id) : Auth::user();

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . ($user->id ?? 'null'),
            'password' => 'sometimes|min:6|confirmed',
>>>>>>> 1d2df3b6af493b7c8db15c210051e591d249e98c
            'role_id' => 'sometimes|exists:roles,id',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
        ]);

<<<<<<< HEAD
        if(isset($validated['password'])) {
=======
        if (isset($validated['password'])) {
>>>>>>> 1d2df3b6af493b7c8db15c210051e591d249e98c
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);
<<<<<<< HEAD
        return response()->json(['message' => 'Utilisateur mis à jour', 'user' => $user]);
    }

=======

        if (!$id) {
            return redirect()->route('profile.view')->with('success', 'Profil mis à jour avec succès.');
        }

        return response()->json(['message' => 'Utilisateur mis à jour', 'user' => $user]);
    }

    /**
     * Supprime un utilisateur
     */
>>>>>>> 1d2df3b6af493b7c8db15c210051e591d249e98c
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['message' => 'Utilisateur supprimé']);
    }
<<<<<<< HEAD
}
=======

    /**
     * Formulaire pour changer le mot de passe
     */
    public function editPassword()
    {
        $user = Auth::user();
        return view('front.profil.password', compact('user'));
    }

    /**
     * Met à jour le mot de passe de l'utilisateur connecté
     */
   public function updatePassword(Request $request)
{
    try {
        if (!$request->ajax()) {
            Log::warning('Non-AJAX request to updatePassword', ['ip' => $request->ip()]);
        }

        $user = Auth::user();
        if (!$user) {
            Log::error('No authenticated user in updatePassword');
            return response()->json(['message' => 'Utilisateur non authentifié.'], 401);
        }

        Log::info('Tentative de changement de mot de passe pour l\'utilisateur:', [
            'user_id' => $user->id,
            'email' => $user->email,
            'request_data' => $request->all(),
            'is_ajax' => $request->ajax()
        ]);

        $currentPassword = $request->input('current_password');
        $newPassword = $request->input('new_password');
        $confirmPassword = $request->input('new_password_confirmation');

        if (!$currentPassword || !$newPassword || !$confirmPassword) {
            return response()->json(['message' => 'Champs requis manquants.'], 422);
        }

        if (!Hash::check($currentPassword, $user->password)) {
            return response()->json(['message' => 'Le mot de passe actuel est incorrect.'], 422);
        }

        if ($newPassword !== $confirmPassword) {
            return response()->json(['message' => 'La confirmation du mot de passe ne correspond pas.'], 422);
        }

        if (Hash::check($newPassword, $user->password)) {
            return response()->json(['message' => 'Le nouveau mot de passe doit être différent de l\'actuel.'], 422);
        }

        $oldPassword = $user->password;
        $user->password = Hash::make($newPassword);

        $saved = $user->save();

        if ($saved) {
            return response()->json(['message' => 'Mot de passe mis à jour avec succès.']);
        } else {
            return response()->json(['message' => 'Erreur lors de la mise à jour du mot de passe.'], 500);
        }
    } catch (\Exception $e) {
        Log::error('Erreur lors du changement de mot de passe:', [
            'user_id' => Auth::id(),
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'request_data' => $request->all()
        ]);
        return response()->json(['message' => 'Une erreur technique s\'est produite.'], 500);
    }
}}
>>>>>>> 1d2df3b6af493b7c8db15c210051e591d249e98c
