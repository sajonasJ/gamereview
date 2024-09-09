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
        <div class="d-flex justify-content-between align-items-center w-100 p-3 bg-dark text-white">
            <h3 class="mb-0 cstm-h3 fw-bold text-uppercase border-bottom border-warning pb-2">
                <i class="bi bi-controller"></i> Publishers Page
            </h3>
        </div>
        <div class="card-body card rounded-4 m-3 p-4 w-75 d-flex align-items-center text-decoration-none text-dark">
            <h1 class="card-title mb-4">{{ $publisher[0]->publisher_name }}</h2>

            @foreach ($publisher as $game)
                <a href="/reviewPage/{{ $game->name }}"
                    class="card d-flex justify-content-center m-3 w-100 text-decoration-none text-dark">
                    <div class="card-body">
                        <h5 class="card-title">Game: {{ $game->name }}</h5>
                        <div class="rating">
                            <span class="me-2"><strong>Rating:</strong></span>
                            @for ($i = 0; $i < floor($game->average_rating); $i++)
                                <i class="bi bi-star-fill text-warning"></i>
                            @endfor

                            @if ($game->average_rating - floor($game->average_rating) >= 0.5)
                                <i class="bi bi-star-half text-warning"></i>
                            @endif

                            @for (; $i < 5; $i++)
                                <i class="bi bi-star text-warning"></i>
                            @endfor
                            <span class="ms-2">({{ number_format($game->average_rating, 2) }} / 5)</span>
                        </div>
                    </div>


                </a>
            @endforeach
        </div>
    </main>
@endsection




@section('footer')
    @include('layouts.footer')
@endsection
