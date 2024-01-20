@extends('layouts.main')
@section('page.title', 'Транзакции')
@section('main.content')

<x-card>
    <x-card-header>
        <x-card-title>
           <p id="transaction">{{__('Список транзакций')}}</p> 
            @if ($transactionCount !== 0)
            <p class="text-muted h6 mt-2">Количество транзакций: {{$transactionCount}}</p>
            @endif
            @include('includes.filter')
        </x-card-title>
        <x-slot name="right">
            <a href="{{route('transaction.create')}}" style="color: grey" id="add">
                {{ __('Добавить') }}
            </a>
        </x-slot>
    </x-card-header>
  <x-success />
  <x-errors />

        <x-card-body>
            @if ($transactions->isEmpty())
                <p id="list">Пока что у вас нет транзакций</p>
            @else
            <x-table>
                <thead>
                  <tr>
                    <th scope="col">Транзакция</th>
                    <th scope="col">Сумма</th>
                    <th scope="col">Категория</th>
                    <th scope="col">Дата</th>
                    <th scope="col">Чек</th>
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
                        @if($transaction->receipt_image)
                        <a href="#" data-toggle="modal" data-target="#receiptModal{{$transaction->id}}">
                            <img src="{{ asset($transaction->receipt_image) }}" alt="Чек" width="50">
                        </a>
                        <div class="modal fade" id="receiptModal{{ $transaction->id }}" tabindex="-1" role="dialog" aria-labelledby="receiptModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <img src="{{ asset($transaction->receipt_image) }}" alt="Чек" class="img-fluid">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
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
<style>
    .introjs-skipbutton {
      position: absolute;
      bottom: 10px;
      right: 100px;
    },
  </style>
<script>
   document.addEventListener("DOMContentLoaded", function() {
    if (!localStorage.getItem('tutorialTransaction')) {
      var intro = introJs();
      intro.setOptions({
        steps: [
            {
            element: document.getElementById('transaction'),
          intro: "Раздел – Транзакции или выписки. Тут вы будете добавлять все все траты или доходы. Невозможно добавить транзакцию без присвоения категории. Поэтому сначала создайте пару категорий",
          position: 'right' 
        },
        {
            element: document.getElementById('add'),
          intro: "Добавьте первые транзакции",
          position: 'right' 
        },
        {
            element: document.getElementById('filter'),
          intro: "Сможете быстро найти транзакцию. Отфильтруйте по дате или по названию",
          position: 'right' 
        },
        {
            element: document.getElementById('list'),
          intro: "Ну а тут будет весь список транзакций",
          position: 'right' 
        },
        ],
        nextLabel: 'Вперед',
        prevLabel: 'Назад',
        doneLabel: 'Завершить',
        exitOnEsc: true,
        exitOnOverlayClick: false
      });

      intro.onexit(function() {
            localStorage.setItem('tutorialTransaction', 'true');
        });

      intro.start();
    }
    });
      </script>
@endsection




