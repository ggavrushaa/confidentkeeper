@if($errors->any() || session('error'))
    <div class="alert alert-danger small p-2">
        <ul class="mb-0">
            @foreach($errors->all() as $message)
                <li>
                    {{ $message }}
                </li>
            @endforeach
            @if(session('error'))
                <li>
                    {{ session('error') }}
                </li>
            @endif
        </ul>
    </div>
@endif