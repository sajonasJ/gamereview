@extends('layouts.master')

@section('title', 'Welcome Page')

@section('header')
    @include('layouts.header')
@endsection

@section('nav')
    @include('layouts.nav')
@endsection

@section('content')
    <main class='publisherListPage-content w-100 d-flex flex-column justify-content-start align-items-center'>
        <div class="d-flex justify-content-between align-items-center w-100 p-3 bg-dark text-white">
            <h3 class="mb-0 cstm-h3 fw-bold text-uppercase border-bottom border-warning pb-2">
                <i class="bi bi-controller"></i> Publishers List
            </h3>
        </div>
        @foreach ($publisherList as $publisher)
            <a href="/publisherPage/{{ $publisher->publisher_name }}"
                class='item card rounded-4 m-3 p-4 w-75 text-decoration-none text-dark'>
                <div class='card-body'>
                    <h2 class='card-title mb-4'>{{ $publisher->publisher_name }}</h2>
                    <div class="d-flex justify-content-start">
                        @if ($publisher->average_rating)
                            <div class="rating">
                                <span class="me-2"><strong>Average Games Rating:</strong></span>
                                @for ($i = 0; $i < floor($publisher->average_rating); $i++)
                                    <i class="bi bi-star-fill text-warning"></i>
                                @endfor
                                @if ($publisher->average_rating - floor($publisher->average_rating) >= 0.5)
                                    <i class="bi bi-star-half text-warning"></i>
                                    @php $i++; @endphp <!-- Increment $i for the half star -->
                                @endif

                                @for (; $i < 5; $i++)
                                    <i class="bi bi-star text-muted"></i>
                                @endfor

                                <span>({{ number_format($publisher->average_rating, 2) }} / 5)</span>
                            </div>
                        @else
                            No ratings yet
                        @endif
                    </div>
                </div>
            </a>
        @endforeach
    </main>
    @include('layouts.toast')
@endsection




@section('footer')
    @include('layouts.footer')
@endsection
