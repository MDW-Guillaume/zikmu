@extends('layout.app')

@section('title')
    Accueil - Zik & Mu
@endsection

@section('content')
    <div class="container">
        <div class="recent_music">
            <h2>Écouté récemment</h2>
            <div class="all_recent_music">
                {{-- @foreach ($recents as $recent) --}}
                <div class="element_recent_music">
                    <div class="image_recent_music">
                        <img src="../ressources/img/play_btn.png">
                    </div>
                    <div class="details_recent_music">
                        <h3>David Bowie</h3>
                        <h4>ChangeOneBowie</h4>
                    </div>
                </div>
                {{-- @endforeach --}}
            </div>
        </div>
        <div class="style_music">
            <h2>Genres &rt</h2>
            <div class="all_style_music">
                {{-- @foreach ($recents as $recent) --}}
                <div class="element_style_music">
                    <div class="text_style_music">
                       <h3>Rock</h3>
                    </div>
                </div>
                {{-- @endforeach --}}
            </div>
        </div>
        <div class="artist_music">
            <h2>Artistes</h2>
             {{-- @foreach ($recents as $recent) --}}

             <div class="element_artist_music">
                <div class="image_artist_music">
                    <img src="" alt="">
                </div>
                <div class="text_artist_music">
                    <h3>Ennio Morricone</h3>
                    <span>Nombre de likes</span>
                </div>
            </div>

            
            {{-- @endforeach --}}
        </div>
    </div>
@endsection
