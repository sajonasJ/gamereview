@extends('layouts.master')

@section('title', 'Homer Page')

@section('header')
    @include('layouts.header')
@endsection

@section('nav')
    @include('layouts.nav')
@endsection

@section('content')
    <main class='homePage-content w-100 d-flex flex-column justify-content-start align-items-center'>
        @foreach($games as $game)
            <a href="/reviewPage/{{$game->name }}" class='item card rounded-4 m-3 p-4 w-75 text-decoration-none text-dark'>
                <div class='card-body'>
                    <h2 class='card-title mb-4'>{{ $game->name }}</h2>
                    <p class='card-subtitle'>Publisher: {{ $game->publisher_name }}</p>
                </div>
            </a>
        @endforeach
    </main>
@endsection






@section('footer')
    @include('layouts.footer')
@endsection
