@extends('layouts.main')
@section('page.title', 'Регистрация')
@section('main.content')
<div class="col-12 col-sm-6 col-md-8 col-lg-10">
<x-card>
    <x-card-header>
        <x-card-title>
            {{__('Регистрация')}}
        </x-card-title>
        <x-slot name="right">
            <a href="{{route('login.index')}}" style="color: grey">
                {{ __('Вход') }}
            </a>
        </x-slot>
    </x-card-header>

    <x-card-body>
        <x-errors />
            <x-form method="POST" action="{{route('reg.store')}}">
                <x-form-item>
                    <x-label required>{{__('Имя')}}</x-label>
                    <x-input name="name" autofocus></x-input>
                </x-form-item>
            <x-form-item>
                <x-label required>{{__('Email')}}</x-label>
                <x-input name="email" type="email"></x-input>
            </x-form-item>
            <x-form-item>
                <x-label required>{{__('Пароль')}}</x-label>
                <x-input name="password" type="password"></x-input>
            </x-form-item>
            <x-form-item>
                <x-label required>{{__('Пароль повторно')}}</x-label>
                <x-input name="password_confirmation" type="password"></x-input>
            </x-form-item>
                <x-button type="submit" color="light">
                    {{__('Зарегистрироваться')}}
                </x-button>
            </x-form>
        </x-card-body>
    </x-card>
</div>
@endsection


