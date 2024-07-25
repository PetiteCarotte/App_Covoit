<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    </header>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
        {{ __('Connexion') }}
    </h2>
    </header>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="form-control mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="form-control mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

    
        <!-- Remember Me -->
        <div class="flex items-center justify-end block mt-4" id="rememberMe">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 light:text-gray-400">{{ __('Remember me') }}</span>
            </label>
           

            @if (Route::has('password.request'))
                <a class="text-sm text-gray-600 light:text-gray-400 hover:text-gray-900 light:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 light:focus:ring-offset-gray-800 "
                    href="{{ route('password.request') }}">
                    {{ __('Mot de passe oublié?') }}
                </a>
            @endif

        </div>

        <div class="flex items-center justify-content-between mt-4">

            <a class="text-sm text-gray-600 light:text-gray-400 hover:text-gray-900 light:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 light:focus:ring-offset-gray-800"
                href="{{ route('register') }}">
                {{ __('Créer un compte') }}
            </a>

            <x-primary-button class="ms-3">
                {{ __('Se connecter') }}
            </x-primary-button>
        </div>




    </form>
</x-guest-layout>