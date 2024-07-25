<!-- Modal Reservation -->

<div style="text-align: left;" class="modal fade" id="reservationModal{{ $trajet->id }}" tabindex="-1" role="dialog"
    aria-labelledby="reservationModalLabel{{ $trajet->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reservationModalLabel{{ $trajet->id }}">
                    Réserver ce trajet
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('reservations.store') }}" method="POST">
                @csrf
                <input type="hidden" name="trajet_id" value="{{ $trajet->id }}">
                <div class="modal-body">
                    <div class="form-group mt-2">
                        <label for="nbr_places_demande{{ $trajet->id }}">Pour
                            combien de passagers souhaitez-vous réserver ?</label>
                        <input type="number" class="form-control" id="nbr_places_demande{{ $trajet->id }}"
                            name="nbr_places_demande" min="1" max="{{$trajet->places_restantes}}" required>
                    </div>
                    <!-- Afficher le nbr de places encore dispo -->
                    <small class="form-text text-muted">
                        Nombre de places restantes : {{ $trajet->places_restantes }}
                    </small>
                    <div class="form-group mt-4">
                        <label for="qte_bagages_demandee{{ $trajet->id }}">Quelle
                            quantité de bagages (en L) souhaitez-vous emporter
                            ?</label>
                        <input type="number" class="form-control" id="qte_bagages_demandee{{ $trajet->id }}"
                            name="qte_bagages_demandee" min="0" max="{{$trajet->bagages_restantes}}" required>
                    </div>
                    <!-- Afficher la quantité de bagages restante -->
                    <small class="form-text mt-4">
                        Quantité de bagages restantes :
                        {{ $trajet->bagages_restantes }} L
                    </small>
                    <div class="form-group mt-4">
                        <label for="commentaire{{ $trajet->id }}">Ajouter un
                            commentaire :
                        </label>
                        <textarea class="form-control" id="commentaire{{ $trajet->id }}" name="commentaire"
                            rows="1"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">Réserver</button>
                </div>
            </form>
        </div>
    </div>
</div>