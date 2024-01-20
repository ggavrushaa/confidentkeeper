@extends('layouts.main')
@section('page.title', 'Добавление транзакции')
@section('main.content')

<x-card>
    <x-card-header>
        <x-card-title>
            {{__('Добавь транзакцию')}}
        </x-card-title>
        <x-slot name="right">
            <a href="{{url()->previous()}}" style="color: grey">
                {{ __('Назад') }}
            </a>
        </x-slot>
    </x-card-header>

    <x-errors />

        <x-card-body>
            <x-form method="POST" action="{{route('transaction.store')}}">
                <x-form-item>
                    <x-label required>{{__('Название')}}</x-label>
                    <x-input name="name" autofocus></x-input>
                </x-form-item>
                <x-form-item>
                    <x-label required>{{__('Сумма')}}</x-label>
                    <x-input type="number" name="amount" step="0.01" min="0"></x-input>
                </x-form-item>
                <x-form-item>
                    <x-label>{{__('Дата')}}</x-label>
                    <x-input name="date" type="date"></x-input>
                </x-form-item>
                <x-form-item>
                    <x-label required>{{__('Категория')}}</x-label>
                    <x-select name="category_id">
                        <option disabled selected >Выбери категорию</option>
                        @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </x-select>
                </x-form-item>
                <x-form-item>
                    <x-label required>{{__('Валюта')}}</x-label>
                    <x-select name="currency_id">
                        <option disabled selected >Выберите валюту</option>
                        @foreach ($currencies as $currency)
                        <option value="{{$currency->id}}">{{$currency->name}}</option>
                        @endforeach
                    </x-select>
                </x-form-item>
                <x-form-item>
                    <x-label>{{__('Комментарий')}}</x-label>
                    <x-textarea name="comment" placeholder="Добавь комментарий к транзакции (необязательно)"></x-textarea>
                </x-form-item>
                <x-form-item>
                    <x-label>{{__('Загрузить чек')}}</x-label>
                    <x-input name="receipt_image" type="file" id="receipt_image"></x-input>
                </x-form-item>
                <x-button type="submit" color="light">
                    {{__('Добавить')}}
                </x-button>
            </x-form>
        </x-card-body>
</x-card>

@endsection


