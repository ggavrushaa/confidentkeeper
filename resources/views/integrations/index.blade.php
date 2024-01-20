@extends('layouts.main')
@section('page.title', 'Интеграции')

@section('main.content')
<x-success />
<div class="row justify-content-center">
    <div class="col-md-6" id="form">
            <x-card-title>
                {{__('Добавьте ваш API Monobank')}}
            </x-card-title>

            <x-form method="POST" action="{{ route('integrations.update') }}" class="mt-2">
                <x-input label="API ключ банка" name="bank_api_key" placeholder="Введите ваш API ключ" value="{{ auth()->user()->bank_api_key }}"></x-input>
                <x-button type="submit" color="light" class="mt-2 mb-2">
                    {{__('Сохранить')}}
                </x-button>
            </x-form>

    </div>
</div>
<style>
    .introjs-skipbutton {
      position: absolute;
      bottom: 10px;
      right: 100px;
    },
  </style>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    if (!localStorage.getItem('tutorialIntegrations')) {
      var intro = introJs();
      intro.setOptions({
        steps: [
        {
            element: document.getElementById('form'),
          intro: "Не скипай эту подсказку! Это поле для твоего апи-токена, если ты захочешь отслеживать свои выписки с monobank в этом приложении. Свой уникальный ключ ты легко найдешь на https://api.monobank.ua/. Просто вставь его в форму и следи за выпиской в разделе – Банк. Нюанс: нельзя заходить на страницу Банк чаще, чем раз в минуту. Не перепугайся, когда вставляешь свой ключ. Сначала ключ хэшируется (в этом же поле твой ключ сразу же преобразуется) из 80 символов я его превращу в 280 и динамически подставляю в код",
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
            localStorage.setItem('tutorialIntegrations', 'true');
        });

      intro.start();
    }
    });
      </script>
@endsection