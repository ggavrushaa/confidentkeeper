@extends('layouts.main')
@section('page.title', 'Вход')
@section('main.content')
<div class="col-12 col-sm-6 col-md-8 col-lg-10">
<x-card>
    <x-card-header>
        <x-card-title>
            {{__('Вход в приложение')}}
        </x-card-title>
        <x-slot name="right">
            <a href="{{route('reg.index')}}" style="color: grey">
                {{ __('Регистрация') }}
            </a>
        </x-slot>
    </x-card-header>
   <x-errors />

    <x-card-body>
            <x-form method="POST" action="{{route('login.store')}}">
            <x-form-item>
                <x-label required>{{__('Email')}}</x-label>
                <x-input name="email" type="email" autofocus></x-input>
            </x-form-item>
            <x-form-item>
                <x-label required>{{__('Пароль')}}</x-label>
                <x-input name="password" type="password"></x-input>
            </x-form-item>
            <x-form-item>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('password.request') }}" style="color: grey">
                        {{ __('Забыли пароль?') }}
                    </a>
                    <x-button type="submit" color="light">
                        {{ __('Войти') }}
                    </x-button>
                </div>
            </x-form-item>
            </x-form>
        </x-card-body>
    </x-card>
</div>
@endsection


