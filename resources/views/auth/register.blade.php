<x-guest-layout>

    </header>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
        {{ __('Register') }}
    </h2>
    </header>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <!-- First Name -->
        <div class="mt-2">
            <x-input-label for="firstname" :value="__('Prénom')" />
            <x-text-input id="firstname" class="form-control mt-1 w-full" type="text" name="firstname"
                :value="old('firstname')" required autofocus autocomplete="firstname" />
            <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
        </div>

        <!-- Name -->
        <div class="mt-2">
            <x-input-label for="name" :value="__('Nom')" />
            <x-text-input id="name" class="form-control mt-1 w-full" type="text" name="name" :value="old('name')"
                required  autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-2">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="form-control mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>


        <!-- NID -->
        <div class="mt-2">
            <x-input-label for="nid" :value="__('NID')" />
            <x-text-input id="nid" class="form-control mt-1 w-full" type="text" name="nid" :value="old('nid')" required
                autocomplete="nid" />
            <x-input-error :messages="$errors->get('nid')" class="mt-2" />
        </div>

        <!-- Unite -->
        <div class="mt-2">
            <x-input-label for="unite" :value="__('Unité')" />
            <x-text-input id="unite" class="form-control mt-1 w-full" type="text" name="unite" :value="old('unite')" />
            <x-input-error :messages="$errors->get('unite')" class="mt-2" />
        </div>

        <!-- Numero de Poste -->
        <div class="mt-2">
            <x-input-label for="numero_de_poste">Numéro de poste<small> ex : 862 000 00 00</small></x-input-label>
            <x-text-input id="numero_de_poste" class="form-control mt-1 w-full" type="text" name="numero_de_poste"
                :value="old('numero_de_poste', '862')" />
            <x-input-error :messages="$errors->get('numero_de_poste')" class="mt-2" />
        </div>


        <!-- Numero de Telephone -->
        <div class="mt-2">
            <x-input-label for="numero_de_telephone" :value="__('Numéro de téléphone')" />
            <x-text-input id="numero_de_telephone" class="form-control mt-1 w-full" type="text"
                name="numero_de_telephone" :value="old('numero_de_telephone')" />
            <x-input-error :messages="$errors->get('numero_de_telephone')" class="mt-2" />
        </div>
        <!-- Commune -->
        <div class="mt-2">
            <x-input-label for="nom_code_commune" :value="__('Commune de préférence')" />
            <x-text-input id="nom_code_commune" class="form-control mt-1 w-full" type="text" name="nom_code_commune"
                list="communes" :value="old('nom_code_commune')" required />
            <datalist id="communes">
                @foreach($communes as $commune)
                    <option value="{{ $commune->nom_de_la_commune }} ({{ $commune->code_postal }})"
                        data-id="{{ $commune->code_commune_insee }}"></option>
                @endforeach
            </datalist>
            <x-input-error :messages="$errors->get('nom_code_commune')" class="mt-2" />
        </div>

        <!-- Base Militaire -->
        <div class="mt-2">
            <x-input-label for="nom_de_la_base" :value="__('Base militaire de préférence')" />
            <x-text-input id="nom_de_la_base" class="form-control mt-1 w-full" type="text" name="nom_de_la_base"
                list="basesMilitaires" :value="old('nom_de_la_base')" required />
            <datalist id="basesMilitaires">
                @foreach($basesMilitaires as $baseMilitaire)
                    <option value="{{ $baseMilitaire->nom_de_la_base }}" data-id="{{ $baseMilitaire->id_base_militaire }}">
                    </option>
                @endforeach
            </datalist>
            <x-input-error :messages="$errors->get('nom_de_la_base')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-2">
            <x-input-label for="password" :value="__('Mot de passe')" />

            <x-text-input id="password" class="form-control mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-2">
            <x-input-label for="password_confirmation" :value="__('Confirmation du mot de passe')" />

            <x-text-input id="password_confirmation" class="form-control mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-content-between mt-4">
            <a class="underline text-sm text-gray-600 light:text-gray-400 hover:text-gray-900 light:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 light:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Se connecter') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Créer un compte') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>