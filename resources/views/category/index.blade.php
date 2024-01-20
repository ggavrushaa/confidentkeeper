@extends('layouts.main')
@section('page.title', 'Категории')
@section('main.content')

  
  <x-card>
    <x-card-header>
      <x-card-title>
        <p id="category">{{__('Список категорий')}}</p>
        @if ($categories->isNotEmpty())
        <p class="text-muted h6 mt-2">Нажмите на категорию для просмотра соответствующих транзакций </p>
        @endif
      </x-card-title>
      <x-slot name="right">
        <a href="{{route('category.create')}}" style="color: grey" id="add">
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
          <thead id="table">
            <tr>
              <th scope="col">Название</th>
              <th scope="col">Тип</th>
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
              <td>{{$category->type == 'income' ? 'Доход' : 'Расход'}}</td>
              <td>
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
    if (!localStorage.getItem('tutorialCategory')) {
      var intro = introJs();
      intro.setOptions({
        steps: [
            {
            element: document.getElementById('category'),
          intro: "Раздел – Категории. Добавляйте категории по тратам или доходам. Тут же при клике на категорию можете посмотреть всю выписку по ней",
          position: 'right' 
        },
        {
            element: document.getElementById('add'),
          intro: "Добавьте первые категории (например: зп, еда, аренда)",
          position: 'right' 
        },
        {
            element: document.getElementById('table'),
          intro: "Тут список всех всех ваших категорий (при клике на навазние категории вы получите выписки по ней)",
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
            localStorage.setItem('tutorialCategory', 'true');
        });

      intro.start();
    }
    });
      </script>
@endsection


