@extends('layouts.master')

@section('title', 'Welcome Page')

@section('header')
    @include('layouts.header')
@endsection

@section('nav')
    @include('layouts.nav')
@endsection

@section('content')
    <main class="reviewPage-content w-100 d-flex flex-column justify-content-start align-items-center">
        @foreach($reviews as $review)
            <div class="item card rounded-4 m-3 p-4 w-75">
                <div class="card-body">
                    <h2 class="card-title mb-4">{{ $review->name }}</h2> <!-- Item name -->
                    <p class="card-subtitle">Publisher: {{ $review->manufacturer_name }}</p> <!-- Manufacturer name -->
                    <p class="card-text">Average Rating: {{ $review->ave_rating }}</p> <!-- Average Rating -->
                    <p class="card-text">Review Count: {{ $review->review_count }}</p> <!-- Review Count -->
                </div>
            </div>
        @endforeach
    </main>
@endsection


@section('footer')
    @include('layouts.footer')
@endsection
