@extends('layout.online')

@section('title')
    Genres
@endsection

@section('scss')
    @vite(['resources/scss/stylepage.scss'])
@endsection

@section('content')
    <div class="page-style page-index">
        <h2>Nos univers</h2>
        <div class="styles-list d-flex">
            @foreach ($styles as $style)
                <a href="{{ route('style.show', $style->slug)}}" class="styles-element">
                    <h3>{{ $style->name }}</h3>
                </a>
            @endforeach
        </div>
    </div>
@endsection