<?php

namespace App\Http\Controllers;

use App\Models\Trajet;
use App\Models\User;
use App\Models\Commune;
use App\Models\BaseMilitaire;
use App\Models\Jours;
use App\Models\Reservation;
use App\Http\Requests\TrajetRequest;
use App\Http\Requests\TrajetUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use DateTime;
use DateTimeZone;
use IntlDateFormatter;

class TrajetController extends Controller
{


    // Affiche tous les trajets
    public function index()
    {

        // Récupérer tous les trajets avec leurs réservations
        $trajets = Trajet::with('reservations')->get();
        $basesMilitaires = BaseMilitaire::all();
        $communes = Commune::all();

        return view('dashboard', compact('trajets', 'communes', 'basesMilitaires'));
    }

    public function vosTrajets()
    {
        $user = Auth::user();

        // Trajets publiés en tant que conducteur
        $trajetsConducteur = Trajet::where('id_conducteur', $user->id)
            ->with([
                'commune',
                'baseMilitaire',
                'reservations' => function ($query) {
                    $query->whereIn('statut', ['Accepté', 'En attente'])->with('user');
                }
            ])
            ->get();

        // Trajets réservés en tant que passager
        $reservations = Reservation::where('id_passager', $user->id)->with('trajet')->get();


        // Tableaux de traduction pour les jours de la semaine et les mois en français
        $joursSemaine = [
            'Monday' => 'Lundi',
            'Tuesday' => 'Mardi',
            'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi',
            'Friday' => 'Vendredi',
            'Saturday' => 'Samedi',
            'Sunday' => 'Dimanche',
        ];

        $mois = [
            'January' => 'janvier',
            'February' => 'février',
            'March' => 'mars',
            'April' => 'avril',
            'May' => 'mai',
            'June' => 'juin',
            'July' => 'juillet',
            'August' => 'août',
            'September' => 'septembre',
            'October' => 'octobre',
            'November' => 'novembre',
            'December' => 'décembre',
        ];

        // Formatage de la date et de l'heure pour chaque trajet
        foreach ($trajetsConducteur as $trajetConducteur) {
            // Création d'un objet DateTime à partir de la date de départ
            $date_depart = new DateTime($trajetConducteur->date_depart);

            // Formatage de la date en français
            $jourSemaineFr = $joursSemaine[$date_depart->format('l')];
            $moisFr = $mois[$date_depart->format('F')];
            $date_depart_formatted = $jourSemaineFr . ' ' . $date_depart->format('j') . ' ' . $moisFr;

            // Formatage de l'heure en "HH:MM"
            $heure_depart_formatted = date('H:i', strtotime($trajetConducteur->heure_depart));

            // Assignez les valeurs formatées au trajet
            $trajetConducteur->date_depart_formatted = $date_depart_formatted;
            $trajetConducteur->heure_depart_formatted = $heure_depart_formatted;

            // Définir les lieux de départ et d'arrivée en fonction de domicile_base
            if ($trajetConducteur->domicile_base) {
                $trajetConducteur->depart = $trajetConducteur->commune->nom_de_la_commune ?? 'Non spécifié';
                $trajetConducteur->arrivee = $trajetConducteur->baseMilitaire->acronyme ?? 'Non spécifié';
            } else {
                $trajetConducteur->depart = $trajetConducteur->baseMilitaire->acronyme ?? 'Non spécifié';
                $trajetConducteur->arrivee = $trajetConducteur->commune->nom_de_la_commune ?? 'Non spécifié';
            }

            // Formatage des jours pour trajets réguliers
            if ($trajetConducteur->trajet_regulier && $trajetConducteur->jours) {
                $trajetConducteur->joursFormatted = $this->formatJours($trajetConducteur->jours);
            }
        }

        // Formatage de la date et de l'heure pour chaque réservation
        foreach ($reservations as $reservation) {
            // Si la réservation a un trajet associé
            if ($reservation->trajet) {
                // Création d'un objet DateTime à partir de la date de départ du trajet
                $date_depart = new DateTime($reservation->trajet->date_depart);

                // Formatage de la date en français
                $jourSemaineFr = $joursSemaine[$date_depart->format('l')];
                $moisFr = $mois[$date_depart->format('F')];
                $reservation->date_depart_formatted = $jourSemaineFr . ' ' . $date_depart->format('j') . ' ' . $moisFr;

                // Formatage de l'heure en "HH:MM"
                $reservation->heure_depart_formatted = date('H:i', strtotime($reservation->trajet->heure_depart));

                // Assigner les valeurs formatées au trajet associé à la réservation
                $reservation->commune = $reservation->trajet->commune;
                $reservation->baseMilitaire = $reservation->trajet->baseMilitaire;

                // Définir les lieux de départ et d'arrivée en fonction de domicile_base
                if ($reservation->trajet->domicile_base) {
                    $reservation->depart = $reservation->trajet->commune->nom_de_la_commune ?? 'Non spécifié';
                    $reservation->arrivee = $reservation->trajet->baseMilitaire->acronyme ?? 'Non spécifié';
                } else {
                    $reservation->depart = $reservation->trajet->baseMilitaire->acronyme ?? 'Non spécifié';
                    $reservation->arrivee = $reservation->trajet->commune->nom_de_la_commune ?? 'Non spécifié';
                }

                // Ajouter la variable de jours pour les réservations régulières
                if ($reservation->trajet->trajet_regulier && $reservation->trajet->jours) {
                    $reservation->joursFormatted = $this->formatJours($reservation->trajet->jours);
                }

            }
        }
        return view('trajets.vosTrajets', compact('trajetsConducteur', 'reservations'));
    }

    private function formatJours($jours)
    {
        $joursArray = [];
        if ($jours->lundi)
            $joursArray[] = 'lundis';
        if ($jours->mardi)
            $joursArray[] = 'mardis';
        if ($jours->mercredi)
            $joursArray[] = 'mercredis';
        if ($jours->jeudi)
            $joursArray[] = 'jeudis';
        if ($jours->vendredi)
            $joursArray[] = 'vendredis';
        if ($jours->samedi)
            $joursArray[] = 'samedis';
        if ($jours->dimanche)
            $joursArray[] = 'dimanches';

        return implode(', ', $joursArray);
    }

    public function search(Request $request)
    {
        $query = Trajet::with(['commune', 'baseMilitaire', 'user']);

        // Critères de filtrage
        if ($request->filled('date_depart')) {
            $dateDepart = $request->date_depart;
            $query->whereDate('date_depart', $dateDepart);
        }

        if ($request->filled('heure_depart')) {
            $heureDepart = $request->heure_depart;
            $query->whereTime('heure_depart', '>=', $heureDepart);
        }

        if ($request->filled('id_commune')) {
            $commune = Commune::where('nom_de_la_commune', $request->id_commune)->first();
            if ($commune) {
                $query->where('id_commune', $commune->code_commune_insee);
            }
        }

        if ($request->filled('id_base_militaire')) {
            $query->where('id_base_militaire', $request->id_base_militaire);
        }

        // Récupérer les trajets
        $trajets = $query->get();

        // Tri par heure de départ pour une meilleure présentation
        $trajets = $trajets->sortBy('heure_depart');

        // Filtrer les trajets pour les points de départ et d'arrivée exacts
        $depart = $request->input('depart');
        $arrivee = $request->input('arrivee');
        $domicile_base = $request->input('domicile_base');

        if ($domicile_base == 'false') {
            $trajets = $trajets->filter(function ($trajet) use ($depart, $arrivee, $domicile_base) {
                return $trajet->domicile_base == false;
            });
        } else {
            $trajets = $trajets->filter(function ($trajet) use ($depart, $arrivee, $domicile_base) {
                return $trajet->domicile_base == true;
            });
        }

        // Tri des trajets réguliers
        if ($request->filled('trajet_regulier')) {
            // Si la case est cochée, trier les trajets réguliers avant
            $trajets = $trajets->sortByDesc(function ($trajet) {
                return $trajet->trajet_regulier ? 1 : 0;
            });
        } else {
            // Si la case n'est pas cochée, trier les trajets réguliers après
            $trajets = $trajets->sortBy(function ($trajet) {
                return $trajet->trajet_regulier ? 1 : 0;
            });
        }

        // Tableaux de traduction pour les jours de la semaine et les mois en français
        $joursSemaine = [
            'Monday' => 'Lundi',
            'Tuesday' => 'Mardi',
            'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi',
            'Friday' => 'Vendredi',
            'Saturday' => 'Samedi',
            'Sunday' => 'Dimanche',
        ];
        $mois = [
            'January' => 'janvier',
            'February' => 'février',
            'March' => 'mars',
            'April' => 'avril',
            'May' => 'mai',
            'June' => 'juin',
            'July' => 'juillet',
            'August' => 'août',
            'September' => 'septembre',
            'October' => 'octobre',
            'November' => 'novembre',
            'December' => 'décembre',
        ];

        // Formatage de la date et de l'heure pour chaque trajet
        foreach ($trajets as $trajet) {
            $date_depart = new DateTime($trajet->date_depart);
            $jourSemaineFr = $joursSemaine[$date_depart->format('l')];
            $moisFr = $mois[$date_depart->format('F')];
            $date_depart_formatted = $jourSemaineFr . ' ' . $date_depart->format('j') . ' ' . $moisFr;
            $heure_depart_formatted = date('H:i', strtotime($trajet->heure_depart));

            $trajet->date_depart_formatted = $date_depart_formatted;
            $trajet->heure_depart_formatted = $heure_depart_formatted;

            if ($trajet->domicile_base) {
                $trajet->depart = $trajet->commune->nom_de_la_commune ?? 'Non spécifié';
                $trajet->arrivee = $trajet->baseMilitaire->nom_de_la_base ?? 'Non spécifié';
            } else {
                $trajet->depart = $trajet->baseMilitaire->nom_de_la_base ?? 'Non spécifié';
                $trajet->arrivee = $trajet->commune->nom_de_la_commune ?? 'Non spécifié';
            }
        }

        return view('trajets.index', [
            'trajets' => $trajets,
            'communes' => Commune::all(),
            'basesMilitaires' => BaseMilitaire::all()
        ]);
    }

    // Affiche le formulaire de création
    public function create()
    {
        // Récupérer les données
        $conducteurs = User::all();
        $basesMilitaires = BaseMilitaire::all();
        $communes = Commune::all();
        $jours = Jours::all();

        // Envoyer les données à la vue
        return view('trajets.create', compact('conducteurs', 'communes', 'basesMilitaires', 'jours'));
    }


    public function store(TrajetRequest $request)
    {
        // Validation des données
        $validated = $request->validated();

        $validated['id_conducteur'] = Auth::id();

        // Définir le statut par défaut à "actif"
        $validated['statut'] = 1;


        // Définir le champ trajet_regulier
        $validated['trajet_regulier'] = $request->has('trajet_regulier') ? 1 : 0;

        // Création du trajet régulier et des jours si nécessaire
        if ($validated['trajet_regulier']) {
            $jours = [
                'lundi' => in_array('lundi', $request->input('jours', [])),
                'mardi' => in_array('mardi', $request->input('jours', [])),
                'mercredi' => in_array('mercredi', $request->input('jours', [])),
                'jeudi' => in_array('jeudi', $request->input('jours', [])),
                'vendredi' => in_array('vendredi', $request->input('jours', [])),
                'samedi' => in_array('samedi', $request->input('jours', [])),
                'dimanche' => in_array('dimanche', $request->input('jours', [])),
            ];

            $joursModel = Jours::create($jours);
            $validated['id_jours'] = $joursModel->id_jours;
        }

        // Création du trajet
        $trajet = Trajet::create($validated);

        // Redirection vers la vue souhaitée avec un message de succès
        return redirect()->route('trajets.vosTrajets')->with('success', 'Le trajet a été publié avec succès.');
    }


    // Affiche un trajet spécifique
    public function show(Trajet $trajet)
    {
        return view('trajets.show', compact('trajet'));
    }

    // Affiche le formulaire pour modifier un trajet
    public function edit(Trajet $trajet)
    {
        // Récupérer les données
        $conducteurs = User::all();
        $communes = Commune::all();
        $basesMilitaires = BaseMilitaire::all();
        $jours = Jours::all();

        // envoyer les données à la vue
        return view('trajets.vosTrajets', compact('trajet', 'communes', 'conducteurs', 'basesMilitaires', 'jours'));
    }

    public function update(TrajetUpdateRequest $request, Trajet $trajet): RedirectResponse
    {
        $trajet->fill($request->validated());
        $trajet->save();

        // Envoi de message à chaque passager
        $reservations = Reservation::where('id_trajet', $trajet->id)
            ->where('statut', 'Accepté')
            ->get();

        foreach ($reservations as $reservation) {
            if($reservation->statut !== 'Refusé'){
                $this->sendMessage($reservation->id_passager, "Le trajet du {$trajet->date_depart} a été modifié par le conducteur.");
            }
        }

        return Redirect::route('trajets.vosTrajets', $trajet->id)->with('status', 'trajet-updated');
    }

    public function accept(Request $request, $id_passager, $id_trajet)
    {
        // Trouver la réservation correspondante
        $reservation = Reservation::where('id_passager', $id_passager)
            ->where('id_trajet', $id_trajet)
            ->firstOrFail();

        // Vérifier si la réservation est en attente
        if ($reservation->statut !== 'En attente') {
            return back()->with('error', 'Cette réservation n\'est pas en attente.');
        }

        // Mettre à jour le statut de la réservation
        $reservation->update(['statut' => 'Accepté']);

        //Mettre a jour le nombre de place occupé
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

        // Envoi de message au passager
        $this->sendMessage($reservation->id_passager, "Votre réservation pour le trajet du {$reservation->trajet->date_depart} a été acceptée.");

        // Redirection avec un message de succès
        return back()->with('success', 'Réservation acceptée avec succès.');
    }

    public function refuse(Request $request, $id_passager, $id_trajet)
    {
        // Trouver la réservation correspondante
        $reservation = Reservation::where('id_passager', $id_passager)
            ->where('id_trajet', $id_trajet)
            ->firstOrFail();

        // Vérifier si la réservation est en attente
        if ($reservation->statut !== 'En attente') {
            return back()->with('error', 'Cette réservation n\'est pas en attente.');
        }

        // Mettre à jour le statut de la réservation
        $reservation->update(['statut' => 'Refusé']);

        // Envoi de message au passager
        $this->sendMessage($reservation->id_passager, "Votre réservation pour le trajet du {$reservation->trajet->date_depart} a été refusée.");

        // Redirection avec un message de succès
        return back()->with('success', 'Réservation refusée avec succès.');
    }

    private function sendMessage($userId, $messageContent)
    {
        $messages = $this->getMessages($userId);
        $messages[] = [
            'subject' => 'Notification de réservation',
            'body' => $messageContent,
            'timestamp' => now()->toDateTimeString(),
            'is_read' => false,

        ];
        $this->storeMessages($userId, $messages);

        $this->incrementUnreadCount($userId);

    }

    private function getMessages($userId)
    {
        $filePath = storage_path("app/messages/{$userId}.json");
        if (file_exists($filePath)) {
            return json_decode(file_get_contents($filePath), true);
        }
        return [];
    }

    private function storeMessages($userId, $messages)
    {
        $filePath = storage_path("app/messages/{$userId}.json");
        file_put_contents($filePath, json_encode($messages));
    }

    private function incrementUnreadCount($userId)
    {
        $countFilePath = storage_path("app/messages/{$userId}_count.json");
        $count = file_exists($countFilePath) ? (int)file_get_contents($countFilePath) : 0;
        file_put_contents($countFilePath, $count + 1);
    }

    public function remove($id_passager, $id_trajet)
    {
        // Trouver la réservation correspondante
        $reservation = Reservation::where('id_passager', $id_passager)
            ->where('id_trajet', $id_trajet)
            ->where('statut', 'Accepté') // Assurez-vous que la réservation est acceptée
            ->firstOrFail();

        // Mettre à jour le statut de la réservation à "En attente" ou autre statut approprié
        $reservation->update(['statut' => 'Refusé']); // Changez "En attente" en ce qui convient à votre logique

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

        $this->sendMessage($reservation->id_passager, "Vous avez été retiré du trajet du {$reservation->trajet->date_depart}.");

        // Redirection avec un message de succès
        return back()->with('success', 'Passager retiré avec succès.');
    }


    // Supprime un trajet spécifique
    public function destroy(Trajet $trajet)
    {
        // Suppression du trajet
        $trajet->delete();

        // Redirection vers la vue souhaitée avec un message de succès
        return redirect()->route('trajets.index')->with('success', 'Le trajet a été supprimé avec succès.');
    }

    /**
     * Supprimer un trajet et ses réservations associées
     * @param \Illuminate\Http\Request $request
     * @param mixed $id
     * @return RedirectResponse
     */
    public function delete(Request $request, $id)
    {
        $user = auth()->user();

        // Récupérer le trajet à supprimer
        $trajet = Trajet::findOrFail($id);

        // Vérifier que l'utilisateur est bien le conducteur du trajet
        if ($trajet->id_conducteur !== $user->id) {
            return redirect()->back()->withErrors(['message' => 'Vous n\'êtes pas autorisé à supprimer ce trajet.']);
        }

        // Annuler les réservations associées
        $reservations = Reservation::where('id_trajet', $trajet->id)->get();

        //Si le passager a été refusé ou retiré, il ne sera pas notifié
        foreach ($reservations as $reservation) {
            if ($reservation->statut !== 'Refusé') {
            $this->sendMessage($reservation->id_passager, "Le trajet du {$trajet->date_depart} a été supprimé par le conducteur.");
            }
            $reservation->delete();
        }

        // Supprimer le trajet
        $trajet->delete();

        return redirect()->back()->with('success', 'Le trajet et ses réservations ont été supprimés avec succès.');
    }
}
