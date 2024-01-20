@extends('layouts.main')

@section('page.title', 'Сброс пароля')

@section('main.content')
<div class="w-50 m-auto">
    <x-card>
        <x-card-header>
            <x-card-title>
                {{ __('Сброс пароля') }}
            </x-card-title>
        </x-card-header>

        <x-errors />

        <x-card-body>
            <x-form method="POST" action="{{ route('password.update') }}">
                <input type="hidden" name="token" value="{{ $token }}">

                <x-form-item>
                    <x-label for="email" required>{{ __('Email') }}</x-label>
                    <x-input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus></x-input>
                </x-form-item>

                <x-form-item>
                    <x-label for="password" required>{{ __('Новый пароль') }}</x-label>
                    <x-input id="password" type="password" name="password" required></x-input>
                </x-form-item>

                <x-form-item>
                    <x-label for="password-confirm" required>{{ __('Подтвердите пароль') }}</x-label>
                    <x-input id="password-confirm" type="password" name="password_confirmation" required></x-input>
                </x-form-item>

                <x-button type="submit" color="light">
                    {{ __('Сбросить пароль') }}
                </x-button>
            </x-form>
        </x-card-body>
    </x-card>
</div>
@endsection
