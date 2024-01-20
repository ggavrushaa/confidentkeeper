@extends('layouts.main')
@section('page.title', 'Обновление категории')
@section('main.content')
<div class="w-50 m-auto">
<x-card>
    <x-card-header>
        <x-card-title>
            {{__('Обновите данные категории')}}
        </x-card-title>
        <x-slot name="right">
            <a href="{{route('category.index')}}" style="color: grey">
                {{ __('Назад') }}
            </a>
        </x-slot>
    </x-card-header>
   <x-errors />

    <x-card-body>
            <x-form method="patch" action="{{route('category.update', $category)}}">
            <x-form-item>
                <x-label required>{{__('Название')}}</x-label>
                <x-input name="name" type="name" autofocus placeholder="{{$category->name}}"></x-input>
            </x-form-item>
            <x-form-item>
                <x-label required>{{__('Тип')}}</x-label>
                <x-select name="type">
                        <option value="income" {{ $category->type == 'income' ? 'selected' : '' }}>Доход</option>
                        <option value="expense" {{ $category->type == 'expense' ? 'selected' : '' }}>Расход</option>
                </x-select>
            </x-form-item>
                <x-button type="submit" color="light">
                    {{__('Обновить')}}
                </x-button>
            </x-form>
        </x-card-body>
    </x-card>
</div>
@endsection


