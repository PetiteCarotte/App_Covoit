<!-- Page Résultats de la recherche -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 light:text-gray-200 leading-tight">
            {{ __('Résultats de la recherche de covoiturage') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white light:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 light:text-gray-100">

                    <h2>Résultats de la recherche</h2>

                    <!-- Affichage des toasts d'erreur -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center"
                            role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                        </div>
                    @endif


                    @if($trajets->isEmpty())
                        <p>Aucun trajet trouvé pour les critères de recherche spécifiés.</p>
                    @else
                        <table class="table">
                            <thead>
                                <!-- Colonnes -->
                                <tr>
                                    <th>Date de départ
                                    <th>Lieu de départ</th>
                                    <th>Lieu d'arrivée</th>
                                    <th style="text-align: center;">Actions</th>
                                </tr>
                            <tbody>
                                @foreach($trajets as $trajet)
                                    <!-- Contenu tableau -->
                                    <tr>
                                        <td>
                                            @if($trajet->trajet_regulier && $trajet->jours)
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
                                                Les {{$joursFormatted}} à {{$trajet->heure_depart_formatted}}
                                            @else
                                                {{ $trajet->date_depart_formatted }} à {{ $trajet->heure_depart_formatted }}</td>
                                            @endif
                                        <td>{{ $trajet->depart }}</td>
                                        <td>{{ $trajet->arrivee }}</td>
                                        <td style="text-align: center;">

                                            @if ($trajet->places_restantes > 0)
                                                <!-- Button Réserver -->
                                                <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#reservationModal{{ $trajet->id }}"
                                                    class="btn btn-success me-1">
                                                    Réserver
                                                </button>
                                            @else
                                            <button type="button" data-bs-toggle="modal"
                                                    class="btn btn-secondary me-1" disabled>
                                                    Complet
                                                </button>
                                            @endif

                                            <!-- Button Détails -->
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#infos{{ $trajet->id }}" class="btn btn-primary me-2"
                                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Détails">
                                                <i class="bi bi-three-dots"></i>
                                            </button>


                                            <!-- Modal Détails -->
                                            @include('trajets.modals-index.details')

                                            <!-- Modal Réservation -->
                                            @include('trajets.modals-index.reservation')
                                            
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
    <style>
        .modal {
            display: none;
        }

        .modal.show {
            display: block;
        }
    </style>

    <script>

        document.addEventListener('DOMContentLoaded', function () {
            const detailButtons = document.querySelectorAll('.details-btn');

            detailButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const modalOverlay = document.querySelector('.modal-overlay');
                    modalOverlay.classList.remove('hidden');
                });
            });

            document.addEventListener('click', function (event) {
                const modalOverlay = document.querySelector('.modal-overlay');
                if (event.target.closest('.modal-close') || !event.target.closest('.modal')) {
                    modalOverlay.classList.add('hidden');
                }
            });

            // Afficher le toast de succès
            var successToast = document.getElementById('successToast');
            if (successToast) {
                var toast = new bootstrap.Toast(successToast);
                toast.show();
            }

            // Afficher le toast d'erreur
            var errorToast = document.getElementById('errorToast');
            if (errorToast) {
                var toast = new bootstrap.Toast(errorToast);
                toast.show();
            }

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })

        });
    </script>
</x-app-layout>