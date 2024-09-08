@extends('layouts.master')

@section('title', 'Item Review Page')

@section('header')
    @include('layouts.header')
@endsection

@section('nav')
    @include('layouts.nav')
@endsection

@section('content')
    <main class="reviewPage-content w-100 d-flex flex-column justify-content-start align-items-center">

        @foreach ($reviews as $review)
            <div class="card item card text-decoration-none  rounded-4 m-3 p-4 w-75">
                <h2 class="card-title  mb-4">{{ $review->name }}</h2>
                <div class="d-flex flex-shrink-1">
                    <a href="/publisherPage/{{ $review->publisher_name }}" class="text-decoration-none">
                        <p class="card-subtitle mb-2 text-decoration-none">Publisher: {{ $review->publisher_name }}</p>
                    </a>
                </div>

                @if ($review->review !== null)
                    <div class="card-body border border-dark">
                        <p class="card-text">Review: {{ $review->review }}</p>
                        <p class="card-text mb-2">Reviewed by: {{ $review->username }}</p>
                        <p class="card-text mb-2">Rating: {{ $review->rating }}/5</p>
                    </div>
                @else
                    <p class="mt-4">No reviews available yet for this game.</p>
                @endif
            </div>
        @endforeach

    </main>
@endsection


@section('footer')
    @include('layouts.footer')
@endsection
