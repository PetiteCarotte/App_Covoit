<!-- Modal Détails Réservation -->


<div style="text-align: left;" class="modal fade"
    id="infos{{ $reservation->id_passager }}-{{ $reservation->id_trajet }}" tabindex="-1" role="dialog"
    aria-labelledby="infosLabel{{ $reservation->id_passager }}-{{ $reservation->id_trajet }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infosLabel{{ $reservation->id_passager }}-{{ $reservation->id_trajet }}">
                    Détails de la réservation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="reservationForm{{ $reservation->id }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_depart{{ $reservation->id }}">Date
                                    de départ :</label>
                                @if($reservation->trajet->trajet_regulier && $reservation->joursFormatted)
                                    
                                    <input type="text" class="form-control" id="date_depart{{ $reservation->id }}"
                                        name="date_depart" value="Les {{ $reservation->joursFormatted }}" disabled>
                                @else
                                    <input type="text" class="form-control" id="date_depart{{ $reservation->id }}"
                                        name="date_depart" value="{{ $reservation->date_depart_formatted }}" disabled>
                                @endif
                            </div>
                            <div class="form-group mt-2">
                                <label for="depart{{ $reservation->id }}">Lieu de
                                    départ :</label>
                                <input type="text" class="form-control" id="depart{{ $reservation->id }}" name="depart"
                                    value="{{ $reservation->depart }}" disabled>
                            </div>
                            <div class="form-group mt-2">
                                <label for="qte_bagages{{ $reservation->id }}">Quantité
                                    de bagages demandé :</label>
                                <input type="text" class="form-control" id="qte_bagages{{ $reservation->id }}"
                                    name="qte_bagages" value="{{ $reservation->qte_bagages_demandee }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="heure_depart{{ $reservation->id }}">Heure
                                    de départ :</label>
                                <input type="text" class="form-control" id="heure_depart{{ $reservation->id }}"
                                    name="heure_depart" value="{{ $reservation->heure_depart_formatted }}" disabled>
                            </div>
                            <div class="form-group mt-2">
                                <label for="arrivee{{ $reservation->id }}">Lieu
                                    d'arrivée :</label>
                                <input type="text" class="form-control" id="arrivee{{ $reservation->id }}"
                                    name="arrivee" value="{{ $reservation->arrivee }}" disabled>
                            </div>
                            <div class="form-group mt-2">
                                <label for="nbr_places{{ $reservation->id }}">Nombre
                                    de places demandées :</label>
                                <input type="text" class="form-control" id="nbr_places{{ $reservation->id }}"
                                    name="nbr_places" value="{{ $reservation->nbr_places_demande }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mt-2">
                                <label for="description{{ $reservation->id }}">Description
                                    du trajet
                                    :</label>
                                <textarea class="form-control" id="description{{ $reservation->id }}" name="description"
                                    rows="2" disabled>{{ $reservation->trajet->description }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mt-2">
                                <label for="commentaire{{ $reservation->id }}">Commentaire
                                    :</label>
                                <textarea class="form-control" id="commentaire{{ $reservation->id }}" name="commentaire"
                                    rows="2" disabled>{{ $reservation->commentaire }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-2">
                                <label for="statutR{{ $reservation->statut}}">Statut
                                    : </label>
                                <input type="text" class="form-control" id="statutR{{$reservation->statut}}"
                                    name="statutR" value="{{$reservation->statut}}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </form>
        </div>
    </div>
</div>