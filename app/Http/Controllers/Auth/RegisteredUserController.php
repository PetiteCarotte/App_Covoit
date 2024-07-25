<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Commune;
use App\Models\BaseMilitaire;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Str;


class RegisteredUserController extends Controller
{
    /**
     * Affiche le formulaire d'inscription.
     */
    public function create(): View
    {
        $communes = Commune::all();
        $basesMilitaires = BaseMilitaire::all();
        return view('auth.register', compact('communes', 'basesMilitaires'));

    }

    /**
     * Traite une demande d'inscription entrante.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        Log::info('Validation réussie', $validated); // Ajouter un log pour la validation



        // Récupérer l'ID de la commune à partir du nom
        $nomCodeCommune = $validated['nom_code_commune'];
        $nomCommune = substr($nomCodeCommune, 0, strpos($nomCodeCommune, ' ('));
        $commune = Commune::where('nom_de_la_commune', $nomCommune)->first();


        $baseMilitaire = BaseMilitaire::where('nom_de_la_base', $validated['nom_de_la_base'])->first();



        $user = User::create([
            'name' => $validated['name'],
            'firstname' => $validated['firstname'],
            'email' => $validated['email'],
            'nid' => $validated['nid'],
            'unite' => $validated['unite'],
            'numero_de_poste' => $validated['numero_de_poste'],
            'numero_de_telephone' => $validated['numero_de_telephone'],
            'password' => Hash::make($validated['password']),
            'id_commune' => $commune->code_commune_insee,
            'id_base_militaire' => $baseMilitaire->id_base_militaire,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
