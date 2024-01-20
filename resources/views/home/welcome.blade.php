@extends('layouts.main')
@section('page.title', 'Учет бюджета')

@section('main.content')

<div class="mt-4 mb-4">
  <x-errors />
    <figure class="text-center">
        <blockquote class="blockquote">
          <p>Keep cold head<br>but boil heart</p>
        </blockquote>
        <div class="mt-4">
            <figcaption class="blockquote-footer">
              Решил написать<cite title="Source Title"> for keep yourself confident</cite>
            </figcaption>
        </div>
      </figure>
    </div>
    {{-- <div class="d-flex justify-content-center">
      <button id="start-tour" class="btn btn-primary">Ознакомительный тур</button>
    </div> --}}

@if (!auth()->check())
<div class="d-flex justify-content-center gap-3">
    
    <x-button color="light" size="md" class>
        <x-link href="{{route('reg.index')}}">Регистрация</x-link>
    </x-button>
    
    
    <x-button color="light" size="md" class="ml-3">
        <x-link href="{{ route('login.index') }}">Вход</x-link>
    </x-button>
    
</div>
@endif
<style>
  .introjs-skipbutton {
    position: absolute;
    bottom: 10px;
    right: 100px;
  }
</style>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    
    if (!localStorage.getItem('tutorialWelcome')) {
      var intro = introJs();
      intro.setOptions({
        steps: [
          {
            element: document.querySelector('blockquote'),
            intro: "Приложение для счета своих денег, всем успехов",
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
            localStorage.setItem('tutorialWelcome', 'true');
        });

      intro.start();
    }
    });
</script>
@endsection


