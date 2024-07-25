<!-- Modal Détails & Modifications -->

<div style="text-align: left;" class="modal fade" id="infos{{ $trajet->id }}" tabindex="-1" role="dialog"
    aria-labelledby="infosLabel{{ $trajet->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infosLabel{{ $trajet->id }}">Détails du
                    covoiturage</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>

            <form method="POST" action="{{ route('trajets.update', ['trajet' => $trajet->id]) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="bd-callout bd-callout-warning">
                        Attention, les points de départ et d'arrivée ne sont pas
                        modifiables, il faudra supprimer et créer un nouveau
                        covoiturage.
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            @if($trajet->trajet_regulier && $trajet->joursFormatted)
                                <div class="form-group mt-2">
                                    <label>Jours de départ :</label>
                                    <input class="form-control" value="Les {{ $trajet->joursFormatted }}">
                                </div>
                            @else
                                <div class="form-group mt-2">
                                    <label for="date_depart_{{ $trajet->id }}">Date de départ :</label>
                                    <input type="date" class="form-control" id="date_depart_{{ $trajet->id }}"
                                        name="date_depart" value="{{ $trajet->date_depart }}">
                                </div>
                            @endif
                            <div class="form-group mt-2">
                                <label for="depart_{{ $trajet->id }}">Lieu de
                                    départ
                                    :</label>
                                <input type="text" class="form-control" id="depart_{{ $trajet->id }}" name="depart"
                                    value="{{ $trajet->depart }}" disabled>
                            </div>
                            <div class="form-group mt-2">
                                <label for="qte_bagages_{{ $trajet->id }}">Quantité
                                    de bagages (en L) :</label>
                                <input type="number" class="form-control" id="qte_bagages_{{ $trajet->id }}"
                                    name="qte_bagages" value="{{ $trajet->qte_bagages }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-2">
                                <label for="heure_depart_{{ $trajet->id }}">Heure
                                    de
                                    départ :</label>
                                <input type="time" class="form-control" id="heure_depart_{{ $trajet->id }}"
                                    name="heure_depart" value="{{ $trajet->heure_depart_formatted }}">
                            </div>
                            <div class="form-group mt-2">
                                <label for="arrivee_{{ $trajet->id }}">Lieu
                                    d'arrivée :</label>
                                <input type="text" class="form-control" id="arrivee_{{ $trajet->id }}" name="arrivee"
                                    value="{{ $trajet->arrivee }}" disabled>
                            </div>
                            <div class="form-group mt-2">
                                <label for="nbr_places_{{ $trajet->id }}">Nombre
                                    de
                                    places :</label>
                                <input type="number" class="form-control" id="nbr_places_{{ $trajet->id }}"
                                    name="nbr_places" value="{{ $trajet->nbr_places }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mt-2">
                                <label for="description_{{ $trajet->id }}">Description
                                    :</label>
                                <textarea class="form-control" id="description_{{ $trajet->id }}" name="description"
                                    rows="3">{{ $trajet->description }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">

                    <button type="submit" class="btn btn-primary" id="btnSave{{ $trajet->id }}">
                        Enregistrer</button>


                    <button type="button" class="btn btn-secondary" id="btnClose{{ $trajet->id }}"
                        data-bs-dismiss="modal">Fermer</button>
                </div>
            </form>
        </div>
    </div>
</div>