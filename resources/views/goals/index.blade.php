@extends('layouts.main')
@section('page.title', 'Список Целей')
@section('main.content')

<div class="container mt-4">
    <x-card-header>
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Ваши цели</h1>
        </div>
        @if ($goals->isEmpty())
            <p>Вы пока что не добавили ни одной цели (не серьезно)</p>
        @endif
    </div>
    <x-slot name="right">
        <a href="{{route('goals.create')}}" style="color: grey" class="add">
            {{ __('Добавить') }}
        </a>
    </x-slot>
    </x-card-header>
    <x-success />
    <x-errors />

    <div class="row">
        @foreach($goals as $goal)
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card">
                @if($goal->image)
                <div class="image-wrapper d-flex justify-content-center align-items-center">
                    <img src="{{ asset('storage/' . $goal->image) }}" alt="{{ $goal->title }}" class="goal-image">
                </div>
                @endif

                <style>
                        .image-wrapper {
                            width: 100%;
                            height: auto;
                            overflow: hidden;
                        }

                        .goal-image {
                            object-fit: cover;
                            min-width: 100%;
                            min-height: 100%;
                        }
                        .introjs-tooltip {
                            position: relative;
                        }

                        .introjs-skipbutton {
                            position: absolute;
                            bottom: 10px;
                            right: 100px;
                        }
                </style>

                <div class="card-body">
                    <h5 class="card-title">{{ $goal->title }}</h5>
                    <p class="card-text">Текущий прогресс: {{ $goal->current_amount }} из {{ $goal->total_amount }}</p>
                    <div class="progress mb-3">
                        @php
                        $progress = ($goal->current_amount / $goal->total_amount) * 100;
                        @endphp
                        <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">{{ round($progress) }}%</div>
                    </div>
                    <span class="badge bg-{{ $goal->status == 'pending' ? 'warning' : 'success' }}">
                        {{ $goal->status == 'pending' ? 'В процессе' : 'Достигнуто' }}
                    </span>                    
                    <p class="mt-2">Дедлайн: {{ \Carbon\Carbon::parse($goal->deadline)->format('d.m.Y') }}</p>
                    @if ($goal->description)
                    <p class="mt-2">Описание: {{$goal->description}}</p>
                    @endif
                </div>
                    <x-link href="{{route('goals.add', $goal)}}" class="btn btn-light tour-button-add">
                        Пополнить счет
                       </x-link>
                <x-link href="{{route('goals.edit', $goal)}}" class="btn btn-light tour-button-edit">
                 Редактировать
                </x-link>
                <x-form action="{{route('goals.delete', $goal)}}" method="delete">
                    <x-button type="submit" class="btn btn-dark tour-button-delete" style="width: 100%;">
                        Удалить
                    </x-button>
                </x-form>
            </div>
        </div>
        @endforeach
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    if (!localStorage.getItem('tutorialGoal')) {
      var intro = introJs();
      intro.setOptions({
        steps: [
            {
        element: document.querySelector('h1.mb-4'),
        intro: "Добро пожаловать в раздел 'Цели'. Здесь вы можете управлять своими целями.",
        position: 'right' 
      },
      {
        element: document.querySelector('a.add'),
        intro: "Тут вы можете добавить ваши цели для накоплений",
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
            localStorage.setItem('tutorialGoal', 'true');
        });

      intro.start();
    }
    });

    </script>
@endsection
