<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Trajet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ReservationController extends Controller
{
    public function store(Request $request)
    {

        $user = Auth::user();
        $trajet = Trajet::findOrFail($request->trajet_id);

        $reservationExists = Reservation::where('id_passager', $user->id)
            ->where('id_trajet', $trajet->id)
            ->exists();

        if ($reservationExists) {
            $errors[] = 'Vous avez déjà réservé ce trajet.';

            //return redirect()->back()->withErrors(['error' => 'Vous avez déjà réservé ce trajet.']);
        }

        // Calculer la quantité totale de bagages déjà demandée par tous les passagers acceptés sur ce trajet
        $totalBagagesAcceptes = $trajet->reservations()
            ->where('statut', 'Accepté')
            ->sum('qte_bagages_demandee');
        // Calculer la quantité de bagages disponibles après avoir pris en compte les réservations acceptées
        $qteBagagesDisponible = $trajet->qte_bagages - $totalBagagesAcceptes;
        // Vérifier si la quantité de bagages demandée par le passager est supérieure à la quantité disponible
        if ($request->qte_bagages_demandee > $qteBagagesDisponible) {
            $errors[] = 'La quantité demandée de bagages dépasse la quantité disponible sur ce trajet.';

            //return redirect()->back()->withErrors(['error' => 'La quantité demandée de bagages dépasse la quantité disponible sur ce trajet.']);
        }

        // Calculer le nombre total de places déjà demandées par tous les passagers acceptés sur ce trajet
        $totalPlacesAcceptees = $trajet->reservations()
            ->where('statut', 'Accepté')
            ->sum('nbr_places_demande');
        // Calculer le nombre de places disponibles après avoir pris en compte les réservations acceptées
        $nbrPlacesDisponible = $trajet->nbr_places - $totalPlacesAcceptees;
        // Vérifier si le nombre de places demandé par le passager est supérieur au nombre de places disponibles
        if ($request->nbr_places_demande > $nbrPlacesDisponible) {
            $errors[] = 'Le nombre de places demandées dépasse le nombre de places disponibles sur ce trajet.';

            //return redirect()->back()->withErrors(['error' => 'Le nombre de places demandées dépasse le nombre de places disponibles sur ce trajet.']);
        }

        // Si des erreurs existent, rediriger avec ces erreurs
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }


        Reservation::create([
            'id_passager' => $user->id,
            'id_trajet' => $trajet->id,
            'qte_bagages_demandee' => $request->qte_bagages_demandee,
            'nbr_places_demande' => $request->nbr_places_demande,
            'commentaire' => $request->commentaire,
            'date_reservation' => now(),
            'statut' => 'En attente',
        ]);

        return redirect()->route('trajets.vosTrajets')->with('success', 'Votre réservation a été enregistrée avec succès.');
    }


    /**
     * Annuler une réservation
     * @param \Illuminate\Http\Request $request
     * @param int $id_passager
     * @param int $id_trajet
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(Request $request, $id_passager, $id_trajet)
    {
        $user = auth()->user();

        // Récupérer la réservation avec les clés composites
        $reservation = Reservation::where('id_passager', $id_passager)->where('id_trajet', $id_trajet)->first();

        // Vérifier si la réservation existe
        if (!$reservation) {
            return redirect()->back()->withErrors(['message' => 'Réservation non trouvée.']);
        }

        // Vérifier que l'utilisateur est le passager de la réservation
        if ($reservation->id_passager !== $user->id) {
            return redirect()->back()->withErrors(['message' => 'Vous n\'êtes pas autorisé à annuler cette réservation.']);
        }

        // Annuler la réservation
        $reservation->delete();

        // Mettre à jour le nombre total de places occupées pour le trajet
        $trajet = Trajet::findOrFail($id_trajet);
        $nbr_places_occupe = Reservation::where('id_trajet', $id_trajet)
            ->where('statut', 'Accepté')
            ->sum('nbr_places_demande');
        $trajet->update(['nbr_places_occupe' => $nbr_places_occupe]);

        //Mettre a jour la quantité de bagage occupée 
        $trajet = Trajet::findOrFail($id_trajet);
        $qte_bagages_occupee = Reservation::where('id_trajet', $id_trajet)
            ->where('statut', 'Accepté')
            ->sum('qte_bagages_demandee');
        $trajet->update(['qte_bagages_occupee' => $qte_bagages_occupee]);

        return redirect()->back()->with('success', 'La réservation a été annulée avec succès.');
    }
}
