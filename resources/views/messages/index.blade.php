<!-- Page Messagerie -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 light:text-gray-200 leading-tight">
            {{ __('Messagerie') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white light:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 light:text-gray-100">
                    @if(count($messages) > 0)
                        @foreach($messages as $index => $message)
                            <div class="card mb-3">
                                <div class="card-header d-flex justify-content-between">
                                    <span>{{ $message['subject'] }}</span>
                                    <form method="POST" action="{{ route('messages.destroy', $index) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                    </form>
                                </div>
                                <div class="card-body">
                                    <p>{{ $message['body'] }}</p>
                                    <small>{{ \Carbon\Carbon::parse($message['timestamp'])->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>Aucun message</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
