@extends('layouts.main')
@section('page.title', 'Создание цели')
@section('main.content')

<x-card>
    <x-card-header>
        <x-card-title>
            {{__('Создай цель')}}
        </x-card-title>
        <x-slot name="right">
            <a href="{{route('goals.index')}}" style="color: grey">
                {{ __('Назад') }}
            </a>
        </x-slot>
    </x-card-header>

        <x-card-body>
            <x-form method="POST" action="{{route('goals.store')}}" enctype="multipart/form-data">

                <x-form-item>
                    <x-label required>{{__('На что соберем?')}}</x-label>
                    <x-input name="title" autofocus></x-input>
                </x-form-item>

                <x-form-item>
                    <x-label>{{__('Описание цели')}}</x-label>
                    <x-textarea name="desсription"></x-textarea>
                </x-form-item>

                <x-form-item>
                    <x-label>{{__('Цель (сумма)')}}</x-label>
                    <x-input type="number" name="total_amount"></x-input>
                </x-form-item>

                <x-form-item>
                    <x-label>{{__('Текущая сумма')}}</x-label>
                    <x-input type="number" name="current_amount" value="0"></x-input>
                </x-form-item>

                <x-form-item>
                    <x-label>{{__('Может фоточку?')}}</x-label>
                    <x-input type="file" name="image" value="0"></x-input>
                </x-form-item>

                <x-form-item>
                    <x-label>{{__('Дедлайн')}}</x-label>
                    <x-input name="deadline" type="date"></x-input>
                </x-form-item>

                <x-button type="submit" color="light">
                    {{__('Создать')}}
                </x-button>

            </x-form>
        </x-card-body>
</x-card>

@endsection


