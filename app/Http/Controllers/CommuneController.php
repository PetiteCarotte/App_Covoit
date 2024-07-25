<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commune;

class CommuneController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');

        // Filtre des communes basé sur la saisie de l'utilisateur
        $communes = Commune::where('nom_de_la_commune', 'like', "%$query%")
            ->orWhere('code_postal', 'like', "%$query%")
            ->take(10) // Limite à 10 résultats
            ->get();

        return response()->json($communes);
    }

}
