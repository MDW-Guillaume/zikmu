<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
</head>
<body
style="
background: linear-gradient(0deg, hsla(259, 69%, 44%, 1) 0%, hsla(323, 86%, 37%, 1) 100%);
"
>
    @yield('content')

    @yield('include.footer')
</body>
</html>