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
        @include('forms.sortItemsForm')
        <!-- Game Cards -->
        @foreach ($games as $game)
            <a href="/reviewPage/{{ $game->id }}" class='item card rounded-4 m-3 p-4 w-75 text-decoration-none text-dark'>
                <div class='card-body'>
                    <h2 class='card-title mb-4'>{{ $game->name }}</h2>
                    <p class='card-subtitle'><strong>Publisher:</strong> {{ $game->publisher_name }}</p>
                    <div class="d-flex justify-content-between">
                        <div class="rating">
                            <span class="me-2"><strong>Average Rating:</strong></span>
                            @for ($i = 0; $i < floor($game->average_rating); $i++)
                                <i class="bi bi-star-fill text-warning"></i> <!-- Full star -->
                            @endfor
                            @if ($game->average_rating - floor($game->average_rating) >= 0.5)
                                <i class="bi bi-star-half text-warning"></i> <!-- Half star -->
                            @endif
                            @for ($i = ceil($game->average_rating); $i < 5; $i++)
                                <i class="bi bi-star text-muted"></i> <!-- Empty star -->
                            @endfor
                            <!-- Show the numeric rating -->
                            <span class="ms-2 text-muted">({{ number_format($game->average_rating, 2) }}/5)</span>

                        </div>


                        <p class='card-text'><strong>Reviews:</strong> {{ $game->review_count }}</p>
                    </div>

                </div>
            </a>
        @endforeach
    </main>

    @include('forms.createItemForm')
    @include('layouts.toast')


@endsection


@section('footer')
    @include('layouts.footer')
@endsection
