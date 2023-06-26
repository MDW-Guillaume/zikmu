<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.2.1/js.cookie.min.js"></script>
    @vite([
        'resources/scss/online.scss',
        'resources/scss/footer.scss',
        'resources/scss/sidebar.scss',
        'resources/scss/app.scss',
        'resources/scss/mixin.scss',
        'resources/scss/artist.scss',
        'resources/scss/album.scss',
        'resources/scss/favorite.scss',
        'resources/scss/stylepage.scss',
        'resources/scss/songqueue.scss',
        'resources/scss/search.scss',
        'resources/scss/profile.scss',
        'resources/js/reload-in-back.js',
    ])
    <title>Zik&Mu - @yield('title')</title>
</head>

<body>
    @include('include.header_phone')
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
