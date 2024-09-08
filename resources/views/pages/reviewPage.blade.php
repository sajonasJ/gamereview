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
        <div class="d-flex justify-content-end w-100 pe-4 p-2 bg-dark text-white">
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addReviewModal">
                Add Review
            </button>
        </div>

        

        <!-- Display game name and publisher name just once before the loop -->
        @if (count($reviews) > 0)
            <div class="card item card text-decoration-none rounded-4 m-3 p-4 w-75">
                <h2 class="card-title mb-4">{{ $reviews[0]->name }}</h2>
                <div class="d-flex flex-shrink-1">
                    <a href="/publisherPage/{{ $reviews[0]->publisher_name }}" class="text-decoration-none">
                        <p class="card-subtitle mb-2 text-decoration-none">Publisher: {{ $reviews[0]->publisher_name }}</p>
                    </a>
                </div>
                <p class="card-subtitle"><strong>Description:</strong> {{ $reviews[0]->description }}</p>

                <!-- Loop through reviews and display them -->
                @foreach ($reviews as $review)
                    @if ($review->review !== null)
                        <div class="card shadow-sm rounded-4 p-3 my-3 w-100 border-0">

                            <blockquote class="blockquote mb-4">
                                <p class="fs-5 fw-semibold text-dark mx-4">"{{ $review->review }}"</p>
                            </blockquote>
                            <footer class="blockquote-footer d-flex justify-content-end mb-3 me-5">
                                <cite title="Reviewer">{{ $review->username }}</cite>
                            </footer>
                            <div class="d-flex justify-content-end align-items-center">
                                <div class="rating">
                                    <span class="text-warning me-2">Rating:</span>
                                    @for ($i = 0; $i < $review->rating; $i++)
                                        <i class="bi bi-star-fill text-warning"></i>
                                    @endfor
                                    @for ($i = $review->rating; $i < 5; $i++)
                                        <i class="bi bi-star text-muted"></i>
                                    @endfor


                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning d-flex justify-content-center align-items-center w-100 mt-3">
                            <strong>No reviews available yet for this game.</strong>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </main>

    @include('forms.createReviewForm')
@endsection


@section('footer')
    @include('layouts.footer')
@endsection


