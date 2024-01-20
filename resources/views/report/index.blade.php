@extends('layouts.main')
@section('page.title', 'Отчеты')

@section('main.content')

<style>
    .custom-card
    {
        width: 16rem;
    }
    .percent-column 
    {
        width: 25%;
    }
    .amount-column
    {
        width: 25%;
    }
    .category-column 
    {
        width: 50%;
    }
    @media (max-width: 768px) {
    .balance-item
    {
        flex-direction: column;
        align-items: center;
    }
}
</style>

<div class="d-flex flex-row flex-wrap mt-3 justify-content-center mb-5 balance-item">

    <div class="card bg-dark text-white custom-card ms-2">
        <div class="card-header">Баланс UAH</div>
        <div class="card-body">
            <h5 class="card-title">{{$uahBalance}}{{$uahCode}}</h5>
        </div>
    </div>
    <div class="card bg-dark text-white custom-card ms-2">
        <div class="card-header">Потрачено</div>
        <div class="card-body">
            <h5 class="card-title">{{$spendAmount}}{{$uahCode}}</h5>
        </div>
    </div>
    <div class="card bg-dark text-white custom-card ms-2">
        <div class="card-header">Заработано</div>
        <div class="card-body">
            <h5 class="card-title">{{$earnAmount}}{{$uahCode}}</h5>
        </div>
    </div>
</div>

<x-card>
    <x-card-header>
        <x-card-title>
            {{__('Отчет по категориям')}}
            @include('includes.report-filter')
        </x-card-title>
        <x-card-title>
            <div class="mb-3 mt-3" id="limitsHighlight">
                {{__('Ваши лимиты')}}
            </div>
        </x-card-title>
        @foreach($categories as $category)
            @if($category->limit)
            <div>
                <strong>{{ $category->name }}</strong>
                <div class="progress" role="progressbar" aria-valuenow="{{today()->day == 1 ? 0 : $category->usagePercent}}" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar" style="width: {{ today()->day == 1 ? 0 : $category->usagePercent }}%">{{today()->day == 1 ? 0 : round($category->usagePercent)}}%</div>
                </div>
            </div>
            @else
            <p>Вы можете задать это в разделе "Лимиты"</p>
            @endif
        @endforeach
    </x-card-header>


        <x-card-body>
            @if (empty($incomeCategoryData))
            <p id="plusTransaction">Пока что у вас нет доходов</p>
            @else
            <x-table>
                <thead>
                  <tr class="text-secondary">
                    <th scope="col" class="category-column">Категория</th>
                    <th scope="col" class="amount-column">Сумма</th>
                    <th scope="col" class="percent-column">Соотношение</th>
                  </tr>
                </thead>
            
                <tbody>
                    <h4 class="text-success">Доходы</h4>
                    @foreach ($incomeCategoryData as $categoryName => $data)
                  <tr>
                    <th scope="row">
                        <x-link href="{{route('category.show', ['category' => $data['category_id']] + request()->query())}}" style="text-decoration:underline">
                            {{$categoryName}}
                            </x-link>
                    </th>
                    <td>
                        <span class="{{$data['type'] == 'income' ?  'text-success' : 'text-danger'}}">
                            {{number_format($data['amount'], 0, '.', '.')}}{{$uahCode}}
                        </span>
                    </td>
                    <td>
                        {{number_format($data['percent'],1)}}%
                    </td>
                @endforeach
                        </tbody>
                    </x-table>
           @endif

           @if (empty($expenseCategoryData))
           <p id="minusTransaction">Пока что у вас нет расходов</p>
            @else
       <x-table>
           <thead>
             <tr class="text-secondary">
               <th scope="col" class="category-column">Категория</th>
               <th scope="col" class="amount-column">Сумма</th>
               <th scope="col" class="percent-column">Соотношение</th>
             </tr>
           </thead>
       
           <tbody>
               <h4 class="text-danger">Расходы</h4>
               @foreach ($expenseCategoryData as $categoryName => $data)
             <tr>
               <th scope="row">
                <x-link href="{{route('category.show', ['category' => $data['category_id']] + request()->query())}}" style="text-decoration:underline">
                    {{$categoryName}}
                    </x-link>
               </th>
               <td>
                   <span class="{{$data['type'] == 'income' ?  'text-success' : 'text-danger'}}">
                       {{number_format($data['amount'], 0, '.', '.')}}{{$uahCode}}
                   </span>
               </td>
               <td>
                   {{number_format($data['percent'],1)}}%
               </td>
           @endforeach
                   </tbody>
               </x-table>
      @endif
    </x-card-body>
</x-card>

<div id="chartTransaction">
    {!! $charts['transactions']->container() !!}
</div>
<div id="chartCategory">
    {!! $charts['category']->container() !!}
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
    if (!localStorage.getItem('tutorialReport')) {
    var intro = introJs();
    intro.setOptions({
      steps: [
        {
          element: document.querySelector('.balance-item'),
          intro: "Ваши счета",
          position: 'right'
        },
        {
          element: document.getElementById('limitsHighlight'),
          intro: "Заданные лимиты по категориям",
          position: 'right'
        },
        {
          element: document.getElementById('plusTransaction'),
          intro: "Плюсовые транзакции выводяться тут",
          position: 'right'
        },
        {
          element: document.getElementById('minusTransaction'),
          intro: "Ваши траты выводятся тут",
          position: 'right'
        },
        {
          element: document.getElementById('chartTransaction'),
          intro: "График по отношению кол-ва транзакций к дате",
          position: 'right'
        },
        {
          element: document.getElementById('chartCategory'),
          intro: "График по отношению общей суммы к конкретной категории",
          position: 'right'
        },
      ],
      nextLabel: 'Вперед',
      prevLabel: 'Назад',
      skipLabel: 'Пропустить',
      doneLabel: 'Завершить',
      exitOnEsc: true,
      exitOnOverlayClick: false
    });

    intro.onexit(function() {
            localStorage.setItem('tutorialReport', 'true');
        });

      intro.start();
    }
    });
      </script>
@endsection

@section('scripts')
    {!! $charts['transactions']->script() !!}
    {!! $charts['category']->script() !!}
@endsection