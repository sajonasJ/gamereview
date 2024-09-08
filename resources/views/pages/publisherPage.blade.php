@extends('layouts.master')

@section('title', 'Welcome Page')

@section('header')
    @include('layouts.header')
@endsection

@section('nav')
    @include('layouts.nav')
@endsection

@section('content')
    <main class="publisherPage-content w-100 d-flex flex-column justify-content-start align-items-center">
        <div class="card-body item card rounded-4 m-3 p-4 w-75 text-decoration-none text-dark" >
            <h2 class="card-title mb-4">{{ $publisher[0]->publisher_name }}</h2> <!-- Display the publisher name outside of the loop -->

            @foreach ($publisher as $game)
                <a href="/reviewPage/{{$game->name}}" class="item card rounded-4 m-3 p-4 w-100 text-decoration-none text-dark">
                    <div class="card-body">
                        <p class="card-subtitle">Game: {{ $game->name }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </main>
@endsection




@section('footer')
    @include('layouts.footer')
@endsection
