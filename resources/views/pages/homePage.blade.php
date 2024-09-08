@extends('layouts.master')

@section('title', 'Home Page')

@section('header')
    @include('layouts.header')
@endsection

@section('nav')
    @include('layouts.nav')
@endsection

@section('content')
    <main class='homePage-content w-100 d-flex flex-column justify-content-start align-items-center'>
        <div class="d-flex justify-content-end w-100 pe-4 p-2 bg-dark text-white">
            <!-- Add Game Button -->
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addGameModal">
                Add Game
            </button>
        </div>

        <!-- Game Cards -->
        @foreach ($games as $game)
            <a href="/reviewPage/{{ $game->name }}" class='item card rounded-4 m-3 p-4 w-75 text-decoration-none text-dark'>
                <div class='card-body'>
                    <h2 class='card-title mb-4'>{{ $game->name }}</h2>
                    <p class='card-subtitle'><strong>Publisher:</strong> {{ $game->publisher_name }}</p>
                </div>
            </a>
        @endforeach
    </main>

    @include('forms.createItemForm')

@endsection


@section('footer')
    @include('layouts.footer')
@endsection