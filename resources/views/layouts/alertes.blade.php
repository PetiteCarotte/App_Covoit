<!-- Alertes -->
@if (Session::has('success') || Session::has('error') || Session::has('info') || Session::has('warning'))
    @php
        $alertTypes = ['success', 'error', 'info', 'warning'];
    @endphp

    @foreach ($alertTypes as $type)
        @if (Session::has($type))
            <div class="alert alert-{{ $type == 'error' ? 'danger' : $type }} alert-dismissible fade show" role="alert">
                {{ Session::get($type) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    @endforeach
@endif
