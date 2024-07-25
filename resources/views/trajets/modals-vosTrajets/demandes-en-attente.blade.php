<!-- Modal Demandes en attente -->

<div class="modal fade" id="demandesModal{{ $trajet->id }}" tabindex="-1" role="dialog"
    aria-labelledby="demandesModalLabel{{ $trajet->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demandesModalLabel{{ $trajet->id }}">
                    Demandes de réservation
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Date demande</th>
                            <th>Passagers </th>
                            <th>Bagages (en L)</th>
                            <th>Commentaire</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trajet->reservations as $reservation)
                            @if($reservation->statut === 'En attente')
                                <tr>
                                    <td>{{ $reservation->user->name }}
                                        {{ $reservation->user->firstname }}
                                    </td>
                                    <td>{{ $reservation->created_at }}</td>
                                    <td>{{ $reservation->nbr_places_demande }}</td>
                                    <td>{{ $reservation->qte_bagages_demandee }}</td>
                                    <td>{{ $reservation->commentaire }}</td>
                                    <td>
                                        <!-- Actions d'acceptation ou de refus -->
                                        <form
                                            action="{{ route('reservations.accept', ['id_passager' => $reservation->id_passager, 'id_trajet' => $reservation->id_trajet]) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Accepter</button>
                                        </form>
                                        <form
                                            action="{{ route('reservations.refuse', ['id_passager' => $reservation->id_passager, 'id_trajet' => $reservation->id_trajet]) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Refuser</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer
                </button>
            </div>
        </div>
    </div>
</div>