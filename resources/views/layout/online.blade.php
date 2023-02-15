<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        @vite(['resources/scss/online.scss'])
        @yield('scss')
        @vite(['resources/scss/sidebar.scss'])
        @vite(['resources/scss/app.scss'])
        @vite(['resources/scss/mixin.scss'])
        <title>Zik&Mu - @yield('title')</title>
    </head>
    <body>
        <div class="container">
            @include('include.sidebar')

            <div class="page-content">
            @yield('content')
            @include('include.footer')
            </div>
        </div>
    </body>
</html>
