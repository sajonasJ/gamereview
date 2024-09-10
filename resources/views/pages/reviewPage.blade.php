@extends('layouts.master')

@section('title', 'Review Page')

@section('header')
    @include('layouts.header')
@endsection

@section('nav')
    @include('layouts.nav')
@endsection

@section('content')
    <main class="reviewPage-content w-100 d-flex flex-column justify-content-start align-items-center">
        <div class="d-flex justify-content-between align-items-center w-100 p-3 bg-dark text-white">
            <h3 class="mb-0 cstm-h3 fw-bold text-uppercase border-bottom border-warning pb-2">
                <i class="bi bi-controller"></i> Game Page
            </h3>
            <div>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addReviewModal">
                    <i class="bi bi-plus-circle"></i> Add Review
                </button>
            </div>
        </div>

        @if (count($reviews) > 0)
            <div class="card item card text-decoration-none rounded-4 m-3 p-4 w-75">
                <div class="d-flex justify-content-between align-items-start">
                    <h1 class="card-title mb-4">{{ $reviews[0]->name }}</h1>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                        data-bs-target="#deleteGameModal">
                        <i class="bi bi-trash"></i> Delete Game
                    </button>
                </div>
                <h4 class="d-flex flex-shrink-1">
                    <a href="/publisherPage/{{ $reviews[0]->publisher_name }}" class="text-decoration-none">
                        <p class="card-subtitle mb-2 text-decoration-none">Publisher: {{ $reviews[0]->publisher_name }}</p>
                    </a>
                </h4>
                <p class="card-subtitle"><strong>Description:</strong> {{ $reviews[0]->description }}</p>

                @foreach ($reviews as $review)

                    @if ($review->review !== null)
                        <div class="card shadow rounded-4 p-3 my-3 w-100 border-0">
                            <div class="d-flex justify-content-between align-items-start">
                                <blockquote class="blockquote d-flex flex-column justify-content-between pe-5 w-100 mb-4">

                                    @if ($review->flagged)
                                        <i class="bi bi-flag-fill text-danger" title="Potential Fake Review">Potential
                                            Fake</i>
                                    @endif
                                    <p class="fs-5 fw-semibold text-dark mx-4">
                                        "{{ $review->review }}"
                                    </p>
                                    <cite class="align-self-end" title="Reviewer">-{{ $review->username }}</cite>
                                </blockquote>
                                <button type="button" class="btn d-flex align-self-start btn-success btn-sm ms-2 w-10"
                                    data-bs-toggle="modal" data-bs-target="#editReviewModal-{{ $review->id }}">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="review-date text-muted fst-italic">
                                    <cite title="Review Date">Review Date:
                                        {{ date('F j, Y', strtotime($review->created_at)) }}</cite>
                                </div>
                                <div class="rating">
                                    <span class="me-2">Rating:</span>

                                    @for ($i = 0; $i < floor($review->rating); $i++)
                                        <i class="bi bi-star-fill text-warning"></i>
                                    @endfor

                                    @if ($review->rating - floor($review->rating) >= 0.5)
                                        <i class="bi bi-star-half text-warning"></i>
                                        @php $i++; @endphp
                                    @endif

                                    @for (; $i < 5; $i++)
                                        <i class="bi bi-star text-warning"></i>
                                    @endfor

                                    <span class="ms-2">({{ number_format($review->rating, 2) }} / 5)</span>
                                </div>
                            </div>
                        </div>

                        @include('forms.updateReviewForm')

                    @else
                        <div class="alert alert-warning d-flex justify-content-center align-items-center w-100 mt-3">
                            <strong>No reviews available yet for this game.</strong>
                        </div>
                    @endif

                @endforeach

            </div>
        @endif
        @include('forms.deleteGameForm')

    </main>

    @include('layouts.toast')
    @include('forms.createReviewForm')
@endsection

@section('footer')
    @include('layouts.footer')
@endsection
