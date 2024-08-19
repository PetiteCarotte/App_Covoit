<!-- Modal Gestion passagers acceptés -->

<div class="modal fade" id="acceptedPassengersModal{{ $trajet->id }}" tabindex="-1" role="dialog"
    aria-labelledby="acceptedPassengersModalLabel{{ $trajet->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="acceptedPassengersModalLabel{{ $trajet->id }}">
                    Passagers acceptés
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Passagers</th>
                            <th>Bagages (en L)</th>
                            <th>Commentaire</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trajet->reservations as $reservation)
                            @if($reservation->statut === 'Accepté')
                                <tr>
                                    <td>{{ $reservation->user->name }}
                                        {{ $reservation->user->firstname }}
                                    </td>
                                    <td>{{ $reservation->nbr_places_demande }}</td>
                                    <td>{{ $reservation->qte_bagages_demandee }}</td>
                                    <td>{{ $reservation->commentaire }}</td>
                                    <td>
                                        <!-- Retirer un passager accepté -->
                                        <form
                                            action="{{ route('reservations.remove', ['id_passager' => $reservation->id_passager, 'id_trajet' => $reservation->id_trajet]) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Retirer le passager">
                                                <i class="bi bi-person-dash-fill"></i>
                                            </button>

                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>