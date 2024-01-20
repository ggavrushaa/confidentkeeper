@extends('layouts.main')
@section('page.title', 'Обновление категории')
@section('main.content')
<div class="w-50 m-auto">
<x-card>
    <x-card-header>
        <x-card-title>
            {{__('Обновите данные транзакции')}}
        </x-card-title>
        <x-slot name="right">
            <a href="{{route('transaction.index')}}" style="color: grey">
                {{ __('Назад') }}
            </a>
        </x-slot>
    </x-card-header>
   <x-errors />

    <x-card-body>
            <x-form method="patch" action="{{route('goals.update', $goal)}}" enctype="multipart/form-data">
            <x-form-item>
                <x-label required>{{__('Название')}}</x-label>
                <x-input name="name" type="name" autofocus placeholder="{{$transaction->name}}"></x-input>
            </x-form-item>
            <x-form-item>
                <x-label required>{{__('Сумма')}}</x-label>
                <x-input type="number" name="amount" step="0.01" min="0" placeholder="{{$transaction->amount}}"></x-input>
            </x-form-item>
            <x-form-item>
                <x-label>{{__('Дата и время')}}</x-label>
                <x-input name="date" type="datetime-local" value="{{ $transaction->created_at->format('Y-m-d\TH:i:s') }}"></x-input>
            </x-form-item>
            {{-- <x-form-item>
                <x-label required>{{__('Валюта')}}</x-label>
                <x-select name="currency">
                    <option value="1001" {{ $transaction->currency_id == '1001' ? 'selected' : '' }}>Доллар</option>
                    <option value="1002" {{ $transaction->currency_id == '1002' ? 'selected' : '' }}>Евро</option>
                    <option value="1003" {{ $transaction->currency_id == '1003' ? 'selected' : '' }}>Гривна</option>
                </x-select>
            </x-form-item> --}}
            <x-form-item>
                <x-label required>{{__('Категория')}}</x-label>
                <x-select name="category">
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}" {{$transaction->category_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                    @endforeach
                </x-select>
            </x-form-item>
            <x-form-item>
                <x-label>{{__('Комментарий')}}</x-label>
                <x-textarea name="comment" placeholder="{{$transaction->comment}}"></x-textarea>
            </x-form-item>
            <x-form-item>
                <x-label>{{__('Изменить чек')}}</x-label>
                <x-input name="receipt_image" type="file" id="receipt_image"></x-input>
            </x-form-item>
                <x-button type="submit" color="light">
                    {{__('Обновить')}}
                </x-button>
            </x-form>
        </x-card-body>
    </x-card>
</div>
@endsection


