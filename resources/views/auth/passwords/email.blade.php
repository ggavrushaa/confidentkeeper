@extends('layouts.main')

@section('page.title', 'Восстановление пароля')

@section('main.content')
<div class="w-50 m-auto">
    <x-card>
        <x-card-header>
            <x-card-title>
                {{ __('Восстановление пароля') }}
            </x-card-title>
        </x-card-header>

        <x-errors />

        <x-card-body>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <x-form method="POST" action="{{ route('password.email') }}">
                <x-form-item>
                    <x-label required for="email">{{ __('Email') }}</x-label>
                    <x-input id="email" name="email" type="email" autofocus></x-input>
                </x-form-item>
                
                <x-button type="submit" color="light">
                    {{ __('Отправить ссылку на сброс пароля') }}
                </x-button>
            </x-form>
        </x-card-body>
    </x-card>
</div>
@endsection
