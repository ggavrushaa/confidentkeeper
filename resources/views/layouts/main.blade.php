@extends('layouts.base')

@section('content')
    <section>
        <x-container>
            @yield('main.content')
        </x-container>
    </section>
    @push('js')
        <script>
            var warningMessage = @json(session('warning', ''));
            if (warningMessage) {
                toastr.warning(warningMessage);
            }
        </script>
    @endpush
@endsection