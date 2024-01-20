@extends('layouts.main')
@section('page.title', 'Обзор категории')

@section('main.content')
<style>
    .custom-card
    {
        width: 16rem;
    }
</style>

<x-card>
    <x-card-header>
        <x-card-title>
            {{__('Выбранная категория – ')}}{{$category->name}}
        </x-card-title>
        <div class="d-flex flex-row flex-wrap mt-3 justify-content-start">
        <div class="card bg-dark text-white custom-card mt-2 mr-3">
            <div class="card-header">
                @if ($category->type == 'income')
                    Доход
                @else
                Расход
                @endif
            </div>
            <div class="card-body">
                <h5 class="card-title">{{$totalAmount}} ₴</h5>
            </div>
        </div>

        <div class="card bg-dark text-white custom-card mt-2 ms-3">
            <div class="card-header">Количество транзакций</div>
            <div class="card-body">
                <h5 class="card-title">{{$transactionCount}}</h5>
            </div>
        </div>
    </div>
    @include('includes.filter')

        <x-slot name="right">
            <a href="{{route('transaction.create')}}" style="color: grey">
                {{ __('Добавить') }}
            </a>
        </x-slot>
    </x-card-header>
  <x-success />
  <x-errors />


        <x-card-body>
            @if ($transactions->isEmpty())
                <p>Пока что у вас нет транзакций</p>
            @else
           
            <x-table>
                <thead>
                  <tr>
                    <th scope="col">Транзакция</th>
                    <th scope="col">Сумма</th>
                    <th scope="col">Категория</th>
                    <th scope="col">Дата</th>
                    <th scope="col">Комментарий</th>
                    <th scope="col">Действие</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                  <tr>
                    <th scope="row">
                        <span class="{{$transaction->category->type == 'income' ?  'text-success' : 'text-danger'}}">
                      {{$transaction->name}}
                        </span>
                    </th>
                    <td>
                        {{$transaction->amount}} {{$transaction->currency->code}}
                    </td>
                    <td>
                            {{$transaction->category->name}} 
                    </td>
                    <td>
                        {{$transaction->created_at->format('d.m.Y H:i')}}
                    </td>
                    <td>
                        {{$transaction->comment}}
                    </td>
                    <td>
                        <x-link href="{{route('transaction.edit', $transaction)}}" class="btn btn-light">
                            Изменить
                        </x-link>
    
                        <span style="margin-right: 10px;"></span>
                        <x-form action="{{route('transaction.delete', $transaction)}}" method="delete" style="display: inline;">
                            <x-button type="submit" class="btn btn-dark">
                                Удалить
                            </x-button>
                        </x-form>
                    </td>
                </tr>
                @endforeach
                </tbody>
              </x-table>
           @endif
           {{$transactions->links()}}
        </x-card-body>
</x-card>
@endsection