<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page.title', config('app.name'))</title>

    <link href="https://cdn.jsdelivr.net/npm/intro.js@7.2.0/minified/introjs.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />


    @stack('css')
    <style>
        .container { max-width: 1320px; }
        .required:after { content: '*'; color: red; }
    </style>
</head>
<body>
    <div class="d-flex flex-column justify-content-between min-vh-100">
        @include('includes.header')

        <main class="flex-grow-1 py-3">
            @yield('content')
        </main>

        @include('includes.footer')
    </div>

    <script src="
    https://cdn.jsdelivr.net/npm/intro.js@7.2.0/intro.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    



    @stack('js')

   
@yield('scripts')
</body>
</html>