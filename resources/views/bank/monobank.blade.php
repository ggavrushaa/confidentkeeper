@extends('layouts.main')
@section('page.title', 'Ваш банк')

@section('main.content')

<div class="card mb-4">
    <div class="card-header bg-dark text-white">
        Информация о клиенте
    </div>
    <div class="card-body">
        <p><strong>Имя:</strong> {{ $clientInfo['name'] }}</p>
    </div>
</div>

<div class="card">
    <div class="card-header bg-dark text-white">
        Транзакции
    </div>
    <table class="table table-dark table-hover mb-0">
        <thead>
            <tr>
                <th>Дата</th>
                <th>Описание</th>
                <th>Сумма</th>
            </tr>
        </thead>
        <tbody>
      
          
              
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ date('d.m.Y H:i:s', $transaction['time']) }}</td>
                    <td>{{ $transaction['description'] }}</td>
                    <td>{{ $transaction['amount'] / 100 }}₴</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-3">
    {{$transactions->links()}}
</div>
</div>
@endsection


