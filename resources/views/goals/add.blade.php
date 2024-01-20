@extends('layouts.main')
@section('page.title', 'Пополнить счет')
@section('main.content')

<x-card>
    <x-card-header>
        <x-card-title>
            {{__('Пополните счет накопления')}}
        </x-card-title>
        <x-slot name="right">
            <a href="{{route('goals.index')}}" style="color: grey">
                {{ __('Назад') }}
            </a>
        </x-slot>
    </x-card-header>

        <x-card-body>
            <x-form method="patch" action="{{route('goals.added', $goal->id)}}" enctype="multipart/form-data">

                <x-form-item>
                    <x-label>{{__('Добавьте сумму')}}</x-label>
                    <x-input type="number" name="amount" value="0"></x-input>
                </x-form-item>

                <x-button type="submit" color="light">
                    {{__('Добавить')}}
                </x-button>

            </x-form>
        </x-card-body>
</x-card>

@endsection


