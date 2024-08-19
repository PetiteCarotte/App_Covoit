<!-- Page Vos trajets -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 light:text-gray-200 leading-tight">
            {{ __('Vos trajets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white light:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 light:text-gray-100">
                    <h2>Trajets publiés en tant que conducteur</h2>
                    @if($trajetsConducteur->isEmpty())
                        <p>Les trajets publiés apparaîtront ici.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date de départ</th>
                                    <th>Lieu de départ</th>
                                    <th>Lieu d'arrivée</th>
                                    <th hidden>Statut</th>
                                    <th style="text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trajetsConducteur as $trajet)
                                    <tr>
                                        <td>
                                            @if($trajet->trajet_regulier && $trajet->joursFormatted)

                                                Les {{ $trajet->joursFormatted }} à {{ $trajet->heure_depart_formatted }}
                                            @else
                                                {{ $trajet->date_depart_formatted }} à {{ $trajet->heure_depart_formatted }}
                                            @endif
                                        </td>
                                        <td>{{ $trajet->depart}}</td>
                                        <td>{{ $trajet->arrivee }}</td>
                                        <td hidden>{{ $trajet->statut }}</td> <!-- 1=actif(imcomplet), 0=inactif(complet) -->
                                        </td>
                                        <td style="text-align: center;">
                                            <!--Demandes Réservations En Attente-->
                                            @if($trajet->reservations->where('statut', 'En attente')->isNotEmpty())
                                                <button type="button" class="btn btn-success clignoter" data-bs-toggle="modal"
                                                    data-bs-target="#demandesModal{{ $trajet->id }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Gérer les demandes">
                                                    <i class="bi bi-person-plus-fill"></i>
                                                </button>

                                                <!-- Modal Demandes en attente -->
                                                @include('trajets.modals-vosTrajets.demandes-en-attente')

                                            @endif


                                            <style>
                                                @keyframes clignoter {
                                                    0% {
                                                        opacity: 1;
                                                    }

                                                    50% {
                                                        opacity: 0;
                                                    }

                                                    100% {
                                                        opacity: 1;
                                                    }
                                                }

                                                .clignoter {
                                                    animation: clignoter 1s infinite;
                                                }
                                            </style>

                                            <!-- Gestion des passagers Acceptés -->
                                            @if($trajet->reservations->where('statut', 'Accepté')->isNotEmpty())
                                                <!-- Button Gestion Passagers Acceptés -->
                                                <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#acceptedPassengersModal{{ $trajet->id }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Gérer les passagers acceptés">
                                                    <i class="bi bi-person-lines-fill"></i>
                                                </button>

                                                <!-- Modal Gestion Passagers Acceptés -->
                                                @include('trajets.modals-vosTrajets.gestion-passagers-acceptes')

                                            @endif

                                            <!-- Button Détails du covoit -->
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#infos{{ $trajet->id }}" class="btn btn-primary"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Détails">
                                                <i class="bi bi-three-dots"></i>
                                            </button>

                                            <!-- Modal Détails & Modifications -->
                                            @include('trajets.modals-vosTrajets.details-modifications-trajet')

                                            <!-- Button Supprimer le covoiturage -->
                                            <form action="{{ route('trajets.delete', ['id' => $trajet->id]) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Supprimer le covoiturage">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    <!-- Trajets Passagers -->
                    <h2>Trajets réservés en tant que passager</h2>
                    @if($reservations->isEmpty())
                        <p>Les trajets réservés apparaîtront ici.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date de départ</th>

                                    <th>Lieu de départ</th>
                                    <th>Lieu d'arrivée</th>
                                    <th style="text-align: center;">Statut</th>
                                    <th style="text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservations as $reservation)
                                    <tr>
                                        <td>
                                            @if($reservation->trajet->trajet_regulier && $reservation->joursFormatted)

                                                Les {{ $reservation->joursFormatted }} à
                                                {{ $reservation->heure_depart_formatted ?? 'Non spécifié' }}
                                            @else
                                                {{ $reservation->date_depart_formatted ?? 'Non spécifié' }} à
                                                {{ $reservation->heure_depart_formatted ?? 'Non spécifié' }}
                                            @endif
                                        </td>
                                        <td>{{ $reservation->depart }}</td>
                                        <td>{{ $reservation->arrivee }}</td>
                                        <td style="text-align: center;">
                                            @if ($reservation->statut == "Accepté")
                                                <h3><span class="badge bg-success" data-bs-toggle="modal" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Accepté par le conducteur"><i
                                                            class="bi bi-check2-circle"></i></span>
                                                </h3>
                                            @endif
                                            @if ($reservation->statut == "En attente")
                                                <h3><span class="badge bg-warning" data-bs-toggle="modal" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="En attente d'une réponse du conducteur"><i
                                                            class="bi bi-hourglass-split"></i></span></h3>
                                            @endif
                                            @if($reservation->statut == "Refusé")
                                                <h3><span class="badge bg-danger" data-bs-toggle="modal" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Refusé par le conducteur"><i
                                                            class="bi bi-x-octagon"></i></span></h3>
                                            @endif
                                        </td>
                                        <td style="text-align: center;">
                                            <!-- Button Détails -->
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#infos{{ $reservation->id_passager }}-{{ $reservation->id_trajet }}"
                                                class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Détails">
                                                <i class="bi bi-three-dots"></i>
                                            </button>

                                            <!-- Button Annuler réservation -->
                                            <form
                                                action="{{ route('reservations.cancel', ['id_passager' => $reservation->id_passager, 'id_trajet' => $reservation->id_trajet]) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Annuler la réservation">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>

                                            <!-- Modal Détails Réservation -->
                                            @include('trajets.modals-vosTrajets.details-reservation')

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>

        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('hidden.bs.modal', function (event) {
                var trajetId = modal.id.replace('infos', '');
                cancelEdit(trajetId);
            });
        });
        /*
                var initialFieldValues = {};
        
                function enableEditMode(trajetId) {
                    const inputs = document.querySelectorAll(`#editForm${trajetId} input[type="number"], #editForm${trajetId} input[type="date"], #editForm${trajetId} input[type="time"], #editForm${trajetId} input[type="text"], #editForm${trajetId} textarea`);
        
        
                    initialFieldValues[trajetId] = {};
        
                    inputs.forEach(input => {
                        if (input.id !== `depart_${trajetId}` && input.id !== `arrivee_${trajetId}`) {
                            initialFieldValues[trajetId][input.id] = input.value;
                            input.disabled = false;
                        }
                    });
        
                    document.getElementById(`btnSave${trajetId}`).classList.remove('d-none');
                    document.getElementById(`btnCancelEdit${trajetId}`).classList.remove('d-none');
                    document.getElementById(`btnEdit${trajetId}`).classList.add('d-none');
                    document.getElementById(`btnClose${trajetId}`).classList.add('d-none');
                }
        
                function cancelEdit(trajetId) {
                    const inputs = document.querySelectorAll(`#editForm${trajetId} input[type="number"], #editForm${trajetId} input[type="date"], #editForm${trajetId} input[type="time"], #editForm${trajetId} input[type="text"], #editForm${trajetId} textarea`);
        
                    inputs.forEach(input => {
                        if (input.id !== `depart_${trajetId}` && input.id !== `arrivee_${trajetId}`) {
                            input.value = initialFieldValues[trajetId][input.id];
                            input.disabled = true;
                        }
                    });
        
                    document.getElementById(`btnSave${trajetId}`).classList.add('d-none');
                    document.getElementById(`btnCancelEdit${trajetId}`).classList.add('d-none');
                    document.getElementById(`btnEdit${trajetId}`).classList.remove('d-none');
                    document.getElementById(`btnClose${trajetId}`).classList.remove('d-none');
                }
        */

        // Initialiser les tooltips
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });


    </script>

    <style>
        .modal {
            display: none;
        }

        .modal.show {
            display: block;
        }

        .bd-callout-warning {
            color: #664d03;
            background: #fff3cd;
            border-color: #997404;
            border-left-width: 5px;
            padding: 1rem;
        }

        .btn-no-hover:hover {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #000;
        }
    </style>
</x-app-layout>