@extends('layouts.main')
@section('page.title', 'Учет бюджета')

@section('main.content')
<div class="mt-4 mb-4">
    <figure class="text-center">
        <blockquote class="blockquote">
          <p>Привет {{$user->name}}, тяжеловато?<br> считай свои деньги, если нужно</p>
        </blockquote>
        <div class="mt-4">
            <figcaption class="blockquote-footer">
              Весь функционал в меню,<cite title="Source Title"> пользуйся чаще</cite>
            </figcaption>
        </div>
      </figure>
</div>
@endsection


