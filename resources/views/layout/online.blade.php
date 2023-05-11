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

    @vite(['resources/scss/artist.scss'])
    @vite(['resources/scss/album.scss'])
    @vite(['resources/scss/favorite.scss'])
    @vite(['resources/scss/stylepage.scss'])
    @vite(['resources/js/multiple-song-play.js'])
    @vite(['resources/js/unique-song-play.js'])
    @vite(['resources/js/favorite.js'])
    @vite(['resources/js/play-album.js'])
    @vite(['resources/js/audio-event.js'])
    @vite(['resources/js/song-controller.js'])
    @vite(['resources/js/waitinglistshow.js'])


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
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

</body>

</html>
