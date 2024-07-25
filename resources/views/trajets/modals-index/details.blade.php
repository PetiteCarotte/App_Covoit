<!-- Modal Details -->

<div style="text-align: left;" class="modal fade" id="infos{{ $trajet->id }}" tabindex="-1" role="dialog"
    aria-labelledby="infosLabel{{ $trajet->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infosLabel{{ $trajet->id }}">Détails
                    du covoiturage</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <form id="trajetForm{{ $trajet->id }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_depart{{ $trajet->id }}">Date
                                    de départ :</label>

                                @if ($trajet->trajet_regulier && $trajet->jours)
                                    @php 
                                        $jours = [];
                                        if ($trajet->jours->lundi) $jours[] = 'lundis';
                                        if ($trajet->jours->mardi) $jours[] = 'mardis';
                                        if ($trajet->jours->mercredi) $jours[] = 'mercredis';
                                        if ($trajet->jours->jeudi) $jours[] = 'jeudis';
                                        if ($trajet->jours->vendredi) $jours[] = 'vendredis';
                                        if ($trajet->jours->samedi) $jours[] = 'samedis';
                                        if ($trajet->jours->dimanche) $jours[] = 'dimanches';
                                        $joursFormatted = implode(', ', $jours);
                                    @endphp
                                    <input class="form-control" value="Les {{$joursFormatted}}" readonly>
                                @else 
                                <input type="text" class="form-control" id="date_depart{{ $trajet->id }}"
                                    name="date_depart" value="{{ $trajet->date_depart_formatted }}" readonly>
                                @endif
                            </div>
                            <div class="form-group mt-2">
                                <label for="depart{{ $trajet->id }}">Lieu de
                                    départ :</label>
                                <input type="text" class="form-control" id="depart{{ $trajet->id }}" name="depart"
                                    value="{{ $trajet->depart }}" readonly>
                            </div>
                            <div class="form-group mt-2">
                                <label for="qte_bagages{{ $trajet->id }}">Quantité
                                    de bagages (en L) :</label>
                                <input type="text" class="form-control" id="qte_bagages{{ $trajet->id }}"
                                    name="qte_bagages" value="{{ $trajet->qte_bagages }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="heure_depart{{ $trajet->id }}">Heure
                                    de départ :</label>
                                <input type="text" class="form-control" id="heure_depart{{ $trajet->id }}"
                                    name="heure_depart" value="{{ $trajet->heure_depart_formatted }}" readonly>
                            </div>
                            <div class="form-group mt-2">
                                <label for="arrivee{{ $trajet->id }}">Lieu
                                    d'arrivée :</label>
                                <input type="text" class="form-control" id="arrivee{{ $trajet->id }}" name="arrivee"
                                    value="{{ $trajet->arrivee }}" readonly>
                            </div>
                            <div class="form-group mt-2">
                                <label for="nbr_places{{ $trajet->id }}">Nombre
                                    de places :</label>
                                <input type="text" class="form-control" id="nbr_places{{ $trajet->id }}"
                                    name="nbr_places" value="{{ $trajet->nbr_places }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mt-2">
                                <label for="description{{ $trajet->id }}">Description
                                    :</label>
                                <textarea class="form-control" id="description{{ $trajet->id }}" name="description"
                                    rows="3" readonly>{{ $trajet->description }}</textarea>
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                                                                        <div class="form-group  mt-2">
                                                                            <label for="statut{{ $trajet->statut }}">Statut
                                                                                :</label>
                                                                            <input type="text" class="form-control"
                                                                                id="statut{{ $trajet->statut }}" name="statut"
                                                                                value="{{ $trajet->statut }}" readonly>
                                                                        </div>
                                                                    </div> -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </form>
        </div>
    </div>
</div>