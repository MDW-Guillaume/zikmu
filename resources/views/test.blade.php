@extends('layout.online')

@section('content')
   <div class="styles-container">
        <h2>Genres ></h2>
        <div class="styles-list d-flex">
            @foreach ($styles as $style)
                <div class="styles-element">
                    <h3>{{$style->name}}</h3>
                </div>
            @endforeach
        </div>
   </div>

   <div class="artists-container">
        <h2>Artistes ></h2>
        <div class="artists-list d-flex">
            @foreach ($artists as $artist)
                <div class="artist-element"> {{-- Link to artist page with slug --}}
                    <div class="artist-cover">
                        <img src="{{ URL::to('/storage') }}/app/files/artistes/{{$artist['style_slug']}}/{{$artist['cover']}}" alt="">
                    </div>
                    <h3>{{$artist['name']}}</h3>
                </div>
            @endforeach
        </div>
   </div>
@endsection
