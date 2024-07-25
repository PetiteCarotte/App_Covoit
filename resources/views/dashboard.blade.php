<!-- Page Recherche d'un covoiturage -->

<x-app-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Recherche d\'un covoiturage') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl mb-6">Rechercher un covoiturage</h1>

                <form action="{{ route('dashboard.search') }}" method="GET" id="searchForm">

                    <div class="flex justify-between mb-4">
                        <div class="w-1/2 pr-2">

                            <div>
                                <x-input-label for="date_depart" :value="__('Date de départ')" />
                                <x-text-input type="date" class="form-control w-full mt-1" id="date_depart"
                                    name="date_depart" value="{{ now()->format('Y-m-d') }}" required />
                            </div>
                        </div>
                        <div class="w-1/2 pl-2">
                            <div>
                                <x-input-label for="heure_depart" :value="__('Heure de départ')" />
                                <x-text-input id="heure_depart" class="form-control mt-1 w-full" type="time"
                                    name="heure_depart" value="{{ now()->setTimezone('Europe/Paris')->format('H:i') }}"
                                    required />
                                <x-input-error :messages="$errors->get('heure_depart')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <input type="checkbox" id="trajet_regulier" name="trajet_regulier"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <x-input-label for="trajet_regulier" :value="__('Trajet régulier')" class="inline-block" />
                    </div>

                    <div id="jours-semaine" class="mb-4" style="display: none;">
                        <x-input-label :value="__('Jours de la semaine')" />
                        <div class="flex flex-wrap space-x-4">
                            <label><input type="checkbox" name="jours[]" value="lundi" class="mr-2">Lundi</label>
                            <label><input type="checkbox" name="jours[]" value="mardi" class="mr-2">Mardi</label>
                            <label><input type="checkbox" name="jours[]" value="mercredi" class="mr-2">Mercredi</label>
                            <label><input type="checkbox" name="jours[]" value="jeudi" class="mr-2">Jeudi</label>
                            <label><input type="checkbox" name="jours[]" value="vendredi" class="mr-2">Vendredi</label>
                            <label><input type="checkbox" name="jours[]" value="samedi" class="mr-2">Samedi</label>
                            <label><input type="checkbox" name="jours[]" value="dimanche" class="mr-2">Dimanche</label>
                        </div>
                    </div>

                    <div class="flex justify-between mb-4">
                        <div class="w-1/2 pr-2">
                            <x-input-label for="id_commune" :value="__('Point de départ')" />
                            <x-text-input id="id_commune" class="form-control mt-1 w-full" type="text"
                                name="id_commune_text" list="communes" required />
                            <x-text-input id="id_commune_hidden" type="hidden" name="id_commune" />
                            <datalist id="communes">
                                @foreach($communes as $commune)
                                    <option value="{{ $commune->nom_de_la_commune }}, {{$commune->code_postal}}"
                                        data-id="{{ $commune->code_commune_insee }}"></option>
                                @endforeach
                            </datalist>
                            <x-input-error :messages="$errors->get('id_commune')" class="mt-2" />
                        </div>

                        <div>
                            <button type="button" id="swap-locations"
                                class="btn btn-outline-secondary mt-2 mb-4 mt-4"><i
                                    class="bi bi-arrow-left-right"></i></button>
                        </div>

                        <div class="w-1/2 pl-2">
                            <x-input-label for="id_base_militaire" :value="__('Point d\'arrivée')" />
                            <x-text-input id="id_base_militaire" class="form-control mt-1 w-full" type="text"
                                name="id_base_militaire_text" list="basesMilitaires" required />
                            <x-text-input id="id_base_militaire_hidden" type="hidden" name="id_base_militaire" />
                            <datalist id="basesMilitaires">
                                @foreach($basesMilitaires as $baseMilitaire)
                                    <option value="{{ $baseMilitaire->nom_de_la_base }}"
                                        data-id="{{ $baseMilitaire->id_base_militaire }}"></option>
                                @endforeach
                            </datalist>
                            <x-input-error :messages="$errors->get('id_base_militaire')" class="mt-2" />
                        </div>
                    </div>

                    <input type="hidden" for="domicile_base" id="domicile_base" name="domicile_base" value="true">

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-4" type="submit">
                            {{ __('Search') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        // Gestion de la sélection des communes et des bases militaires
        document.addEventListener('DOMContentLoaded', function () {
            const communeInput = document.getElementById('id_commune');
            const communeHiddenInput = document.getElementById('id_commune_hidden');
            const communeDatalist = document.getElementById('communes');

            // Lorsque l'utilisateur saisit une commune, on met à jour la valeur du champ caché
            communeInput.addEventListener('input', function () {
                const selectedOption = Array.from(communeDatalist.options).find(option => option.value === this.value);
                communeHiddenInput.value = selectedOption ? selectedOption.dataset.id : '';
            });

            // Gestion de la sélection des bases militaires
            const baseMilitaireInput = document.getElementById('id_base_militaire');
            const baseMilitaireHiddenInput = document.getElementById('id_base_militaire_hidden');
            const baseMilitaireDatalist = document.getElementById('basesMilitaires');

            // Lorsque l'utilisateur saisit une base militaire, on met à jour la valeur du champ caché
            baseMilitaireInput.addEventListener('input', function () {
                const selectedOption = Array.from(baseMilitaireDatalist.options).find(option => option.value === this.value);
                baseMilitaireHiddenInput.value = selectedOption ? selectedOption.dataset.id : '';
            });

            const domicileBaseInput = document.getElementById('domicile_base'); // Ajout
            let clickCount = 0; // Compteur de clics

            // Gestion de l'inversion des points de départ et d'arrivée
            const swapButton = document.getElementById('swap-locations');
            // Lorsque l'utilisateur clique sur le bouton d'inversion
            swapButton.addEventListener('click', function () {
                clickCount++; // Incrémente le compteur de clics à chaque clic

                const idCommune = communeInput.value;
                const idBaseMilitaire = baseMilitaireInput.value;

                communeInput.value = idBaseMilitaire;
                baseMilitaireInput.value = idCommune;

                //domicileBaseInput.value = (clickCount % 2 !== 0).toString();

                // Inversion du champ domicile_base
                const isDomicileBase = document.getElementById('domicile_base');
                isDomicileBase.value = isDomicileBase.value === 'true' ? 'false' : 'true';
            });

            // Afficher/masquer les jours de la semaine en fonction de la case "Trajet régulier"
            const trajetRegulierCheckbox = document.getElementById('trajet_regulier');
            const joursSemaineDiv = document.getElementById('jours-semaine');
            const dateDepartInput = document.getElementById('date_depart');

            trajetRegulierCheckbox.addEventListener('change', function () {
                const isChecked = this.checked;
                joursSemaineDiv.style.display = isChecked ? 'block' : 'none';
                dateDepartInput.disabled = isChecked;
            });
        });
    </script>

</x-app-layout>