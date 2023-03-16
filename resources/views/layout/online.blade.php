<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        @vite(['resources/scss/online.scss'])
        @vite(['resources/scss/footer.scss'])
        @yield('scss')
        @vite(['resources/scss/sidebar.scss'])
        @vite(['resources/scss/app.scss'])
        @vite(['resources/scss/mixin.scss'])
        @vite(['resources/js/reload-in-back.js'])

        @vite(['resources/scss/favorite.scss'])
        @vite(['resources/js/song-play.js'])
        
        <title>Zik&Mu - @yield('title')</title>
    </head>
    <body>
        <div class="container">
            @include('include.sidebar')

            <div class="page-content">
                <div class="display-message hidden" id="displayMessageContainer">
                    <p class="message" id="displayMessage"></p>
                </div>
            @yield('content')
            @include('include.footer')
            </div>
        </div>
    </body>
</html>
