@extends('layouts.main')
@section('page.title', 'Создание категории')
@section('main.content')

<x-card>
    <x-card-header>
        <x-card-title>
            {{__('Создай категорию')}}
        </x-card-title>
        <x-slot name="right">
            <a href="{{route('category.index')}}" style="color: grey">
                {{ __('Назад') }}
            </a>
        </x-slot>
    </x-card-header>

        <x-card-body>
            <x-form method="POST" action="{{route('category.store')}}">
                <x-form-item>
                    <x-label required>{{__('Название')}}</x-label>
                    <x-input name="name" autofocus></x-input>
                </x-form-item>
            <x-form-item>
                <x-label required>{{__('Тип')}}</x-label>
                <x-select name="type">
                    <option disabled selected >Выбери тип категории</option>
                    <option value="income">Доход</option>
                    <option value="expense">Расход</option>
                </x-select>
                
            </x-form-item>
                <x-button type="submit" color="light">
                    {{__('Создать')}}
                </x-button>
            </x-form>
        </x-card-body>
</x-card>

@endsection


