@extends('layout.online')

@section('content')
    <div id="content">
        <div class="page-album page-index page-artist page-profile">
            <h2>Mon compte</h2>
            @if ($username != null)
            <div class="user-container">
                <img src="{{ URL::to('img') }}/user.svg" alt="">
                <p>{{ $username }}</p>
            </div>
            @endif

            <div class="user-navigation">
                <ul>
                    <li class="user-navigation-page"><a href="{{ route('album.myalbums') }}">Albums<span>></span></a></li>
                    <li class="user-navigation-page"><a href="{{ route('favorite.show') }}">Titres<span>></span></a></li>
                    <li class="user-navigation-page"><a href="{{ route('artist.myartists') }}">Artistes<span>></span></a>
                    </li>
                    <li class="user-navigation-profile"><a href="{{ route('profile.show') }}">
                            <div class="user-navigation-profile-title">
                                <img src="{{ URL::to('/img') }}/avatar.png">Mon compte
                            </div><span>></span>
                        </a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
