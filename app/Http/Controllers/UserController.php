<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Commune;
use App\Models\BaseMilitaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['commune', 'baseMilitaire'])->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $communes = Commune::all();
        $basesMilitaires = BaseMilitaire::all();
        return view('users.create', compact('communes', 'basesMilitaires'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nid' => 'required|string|max:255|unique:users',
            'unite' => 'nullable|string|max:255',
            'numero_de_poste' => 'nullable|string|max:255',
            'numero_de_telephone' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'id_commune' => 'nullable|exists:communes,id',
            'id_base_militaire' => 'nullable|exists:base_militaires,id_base_militaire',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id); // Récupère l'utilisateur par son ID
        return view('users.show', compact('user')); // Envoie l'utilisateur à la vue
    }

    public function edit(User $user)
    {
        $communes = Commune::all();
        $basesMilitaires = BaseMilitaire::all();
        return view('users.edit', compact('user', 'communes', 'basesMilitaires'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'nid' => 'required|string|max:255|unique:users,nid,' . $user->id,
            'unite' => 'nullable|string|max:255',
            'numero_de_poste' => 'nullable|string|max:255',
            'numero_de_telephone' => 'nullable|string|max:255',
            'password' => 'sometimes|nullable|string|min:8|confirmed',
            'id_commune' => 'nullable|exists:communes,id',
            'id_base_militaire' => 'nullable|exists:base_militaires,id',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
