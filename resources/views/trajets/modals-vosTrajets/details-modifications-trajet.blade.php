<!-- Modal Détails & Modifications -->
<div style="text-align: left;" class="modal fade" id="infos{{ $trajet->id }}" tabindex="-1" role="dialog"
    aria-labelledby="infosLabel{{ $trajet->id }}" aria-hidden="true" data-trajet-id="{{ $trajet->id }}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infosLabel{{ $trajet->id }}">Détails du covoiturage</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="trajetForm{{ $trajet->id }}" method="POST"
                action="{{ route('trajets.update', ['trajet' => $trajet->id]) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="bd-callout bd-callout-warning">
                        Attention, les points de départ et d'arrivée ne sont pas modifiables, il faudra supprimer et
                        créer un nouveau covoiturage.
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            @if($trajet->trajet_regulier && $trajet->joursFormatted)
                                <div class="form-group mt-2">
                                    <label>Jours de départ :</label>
                                    <input class="form-control" value="Les {{ $trajet->joursFormatted }}" disabled>
                                </div>
                            @else
                                <div class="form-group mt-2">
                                    <label for="date_depart_{{ $trajet->id }}">Date de départ :</label>
                                    <input type="date" class="form-control" id="date_depart_{{ $trajet->id }}"
                                        name="date_depart" value="{{ $trajet->date_depart }}"
                                        data-trajet-id="{{ $trajet->id }}" data-field="date_depart">
                                    <x-input-error class="mt-2" :messages="$errors->get('date_depart')" />
                                </div>
                            @endif
                            <div class="form-group mt-2">
                                <label for="depart_{{ $trajet->id }}">Lieu de départ :</label>
                                <input type="text" class="form-control" id="depart_{{ $trajet->id }}" name="depart"
                                    value="{{ $trajet->depart }}" disabled>
                            </div>
                            <div class="form-group mt-2">
                                <label for="qte_bagages_{{ $trajet->id }}">Quantité de bagages (en L) :</label>
                                <input type="number" class="form-control" id="qte_bagages_{{ $trajet->id }}"
                                    name="qte_bagages" value="{{ $trajet->qte_bagages }}"
                                    data-trajet-id="{{ $trajet->id }}" data-field="qte_bagages">
                                <x-input-error class="mt-2" :messages="$errors->get('qte_bagages')" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-2">
                                <label for="heure_depart_{{ $trajet->id }}">Heure de départ :</label>
                                <input type="time" class="form-control" id="heure_depart_{{ $trajet->id }}"
                                    name="heure_depart" value="{{ $trajet->heure_depart_formatted }}"
                                    data-trajet-id="{{ $trajet->id }}" data-field="heure_depart">
                                <x-input-error class="mt-2" :messages="$errors->get('heure_depart')" />
                            </div>
                            <div class="form-group mt-2">
                                <label for="arrivee_{{ $trajet->id }}">Lieu d'arrivée :</label>
                                <input type="text" class="form-control" id="arrivee_{{ $trajet->id }}" name="arrivee"
                                    value="{{ $trajet->arrivee }}" disabled>
                            </div>
                            <div class="form-group mt-2">
                                <label for="nbr_places_{{ $trajet->id }}">Nombre de places :</label>
                                <input type="number" class="form-control" id="nbr_places_{{ $trajet->id }}"
                                    name="nbr_places" value="{{ $trajet->nbr_places }}"
                                    data-trajet-id="{{ $trajet->id }}" data-field="nbr_places">
                                <x-input-error class="mt-2" :messages="$errors->get('nbr_places')" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mt-2">
                                <label for="description_{{ $trajet->id }}">Description :</label>
                                <textarea class="form-control" id="description_{{ $trajet->id }}" name="description"
                                    rows="3" data-trajet-id="{{ $trajet->id }}"
                                    data-field="description">{{ $trajet->description }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('description')" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary" id="btnSave{{ $trajet->id }}">Enregistrer les modifications</button>
                    <button type="button" class="btn btn-secondary" id="btnClose{{ $trajet->id }}"
                        data-bs-dismiss="modal">Fermer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-trajet-id]').forEach(function (element) {
            var trajetId = element.getAttribute('data-trajet-id');
            var field = element.getAttribute('data-field');
            
            // Sauvegarder les valeurs initiales
            element.setAttribute('data-initial-value', element.value);

            // Charger les données sauvegardées lors de l'ouverture de la modal
            element.value = localStorage.getItem('trajet_' + trajetId + '_' + field) || element.value;

            // Sauvegarder les données lorsque l'utilisateur les modifie
            element.addEventListener('input', function () {
                localStorage.setItem('trajet_' + trajetId + '_' + field, element.value);
            });
        });

        // Clear form data from localStorage when modal is closed without saving
        document.querySelectorAll('.modal').forEach(function (modal) {
            modal.addEventListener('hidden.bs.modal', function (event) {
                var trajetId = modal.getAttribute('data-trajet-id');
                restoreInitialValues(trajetId);
                clearFormData(trajetId);
            });
        });
    });

    function restoreInitialValues(trajetId) {
        document.querySelectorAll('[data-trajet-id="' + trajetId + '"]').forEach(function (element) {
            var initialValue = element.getAttribute('data-initial-value');
            element.value = initialValue;
        });
    }

    function clearFormData(trajetId) {
        document.querySelectorAll('[data-trajet-id="' + trajetId + '"]').forEach(function (element) {
            var field = element.getAttribute('data-field');
            localStorage.removeItem('trajet_' + trajetId + '_' + field);
        });
    }
</script>
