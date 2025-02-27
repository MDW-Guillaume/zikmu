<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        @vite([
            'resources/scss/app.scss',
            'resources/scss/mixin.scss'
        ])
        <title>Zik&Mu - @yield('title')</title>
    </head>
    <body>
        <div class="container login">
            <h1>
                <a href="{{ route('landing') }}">
                    <img src="{{ URL::to('/') }}/img/logo.png" alt="Zik&Mu">
                </a>
            </h1>
    @yield('content')

    {{-- @include('include.footer') --}}
    </div>
</body>
</html>