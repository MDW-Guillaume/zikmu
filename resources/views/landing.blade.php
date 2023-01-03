@extends('layout.app')

@section('title')
    Zik&Mu - Bienvenue
@endsection

@section('content')
    <h1>
        <a href="{{ route('landing') }}">
            <img src="{{ URL::to('/') }}/img/logo.png" alt="Zik&Mu">
        </a>
    </h1>
@endsection