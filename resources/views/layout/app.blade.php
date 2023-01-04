<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @googlefonts('righteous')
    @vite(['resources/scss/app.scss'])
    <title>@yield('title')</title>
</head>
<body>
    @yield('content')

    {{-- @include('include.footer') --}}
</body>
</html>