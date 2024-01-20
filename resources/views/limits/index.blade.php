@extends('layouts.main')
@section('page.title', 'Отчеты')

@section('main.content')
  <x-card>
    <x-card-header>
        <x-card-title>
            <p id="welcome">{{__('Список категорий')}}</p>
            @if ($categories->isNotEmpty())
            <p class="text-muted h6 mt-2">Нажмите на категорию для просмотра соответствующих транзакций </p>
            @endif
        </x-card-title>
        <x-slot name="right">
            <a href="{{route('category.create')}}" style="color: grey">
                {{ __('Добавить') }}
            </a>
        </x-slot>
    </x-card-header>
  <x-success />
  <x-errors />

        <x-card-body>
            @if ($categories->isEmpty())
                <p>Пока что вы не добавили ни одной категории</p>
            @else
           <div class="table-responsive">
            <x-table>
                <thead>
                  <tr>
                    <th scope="col">Название</th>
                    <th scope="col">Лимит</th>
                    <th scope="col">Действие</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ( $categories as $category)
                  <tr>
                    <th scope="row" class="{{$category->type == 'income' ? 'text-success' : 'text-secondary'}}">
                        <x-link href="{{route('category.show', $category)}}" style="text-decoration:underline">
                        {{$category->name}}
                        </x-link>
                    </th>
                    <td id="limit">
                        <x-form method="POST" action="{{route('limits.update', $category)}}">
                            <x-input name="limit" value="{{$category->limit}}"></x-input>
                            <x-button type="submit" color="light" class="mt-2">
                                {{__('Сохранить')}}
                            </x-button>
                        </x-form>
                    </td>
                    <td id="btn">
                        <x-link href="{{route('category.edit', $category->id )}}" class="btn btn-light">
                            Изменить
                        </x-link>
                        <span style="margin-right: 10px;"></span>
                        <x-form action="{{route('category.delete', $category)}}" method="delete" style="display: inline;">
                            <x-button type="submit" class="btn btn-dark">
                                Удалить
                            </x-button>
                        </x-form>
                    </td>
                </tr>
                @endforeach
                </tbody>
              </x-table>
            </div>
           @endif
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
    if (!localStorage.getItem('tutorialLimit')) {
      var intro = introJs();
      intro.setOptions({
        steps: [
            {
            element: document.getElementById('welcome'),
          intro: "Раздел – Лимиты: задайте лимит на расходные категории и получайте уведомление, если лимит скоро заполнится. В отчетах смотрите статистику по лимитам",
          position: 'bottom' 
        },
        {
            element: document.getElementById('btn'),
          intro: "Кнопки думаю понятные",
          position: 'bottom' 
        },
        {
            element: document.getElementById('limit'),
          intro: "Задайте числом лимит и сохраняйтесь",
          position: 'bottom' 
        },
        ],
        nextLabel: 'Вперед',
        prevLabel: 'Назад',
        doneLabel: 'Завершить',
        exitOnEsc: true,
        exitOnOverlayClick: false
      });

      intro.onexit(function() {
            localStorage.setItem('tutorialLimit', 'true');
        });

      intro.start();
    }
    });
      </script>
@endsection