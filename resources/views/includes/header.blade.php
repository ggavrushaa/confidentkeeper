<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <x-container>

    <a class="navbar-brand" href="{{route('welcome')}}">Confident Keeper</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>


    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav mx-auto justify-content-center">
        <li class="nav-item">
          <a class="nav-link" href="{{route('report.index')}}" @activeLink('report.index')>Отчеты</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('goals.index')}}" @activeLink('goals.index')>Цели</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('category.index')}}" @activeLink('category.index')>Категории</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('transaction.index')}}" @activeLink('transaction.index')>Платежи</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('monobank.index')}}" @activeLink('monobank.index')>Банк</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('integrations.index')}}" @activeLink('integrations.index')>Интеграции</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('limits.index')}}" @activeLink('limits.index')>Лимиты</a>
        </li>
        @if (auth()->check())
        <li class="nav-item ms-4">
          <x-form method="POST" action="{{route('login.out')}}">
            <button type="submit" class="nav-link btn btn-link" style="color: grey; font-weight: 400; background: none; border: none; cursor: pointer;">Выйти</button>
          </x-form>
        </li>
        @endif
      </ul>
    </div>
  </x-container>
</nav>
