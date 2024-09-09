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
        <div class="d-flex justify-content-between align-items-center w-100 p-3 bg-dark text-white">
            <h3 class="mb-0 cstm-h3 fw-bold text-uppercase border-bottom border-warning pb-2">
                <i class="bi bi-controller"></i> Game Page
            </h3>
            <div>
                <!-- Add Review Button -->
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addReviewModal">
                    <i class="bi bi-plus-circle"></i> Add Review
                </button>
            </div>
        </div>

        @if (count($reviews) > 0)
            <div class="card item card text-decoration-none rounded-4 m-3 p-4 w-75">
                <div class="d-flex justify-content-between align-items-start">
                    <h1 class="card-title mb-4">{{ $reviews[0]->name }}</h1>
                    <!-- Delete Game Button -->
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
                        <div class="card shadow-sm rounded-4 p-3 my-3 w-100 border-0">
                            <button type="button" class="btn btn-outline-secondary btn-sm ms-2" data-bs-toggle="modal"
                                data-bs-target="#editReviewModal-{{ $review->id }}">
                                <i class="bi bi-pencil"></i> Edit
                            </button <blockquote class="blockquote mb-4">
                            <p class="fs-5 fw-semibold text-dark mx-4">"{{ $review->review }}"</p>

                            </blockquote>
                            <footer class="blockquote-footer d-flex justify-content-end mb-3 me-5">
                                <cite title="Reviewer">{{ $review->username }}</cite>
                            </footer>
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

                        <!-- Edit Review Modal -->
                        <div class="modal fade" id="editReviewModal-{{ $review->id }}" tabindex="-1"
                            aria-labelledby="editReviewModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editReviewModalLabel">Edit Review</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Edit Review Form -->
                                        <form action="/updateReview/{{ $review->id }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="review" class="form-label">Review</label>
                                                <textarea class="form-control" id="review" name="review" rows="3" required>{{ $review->review }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="rating" class="form-label">Rating</label>
                                                <select class="form-select" id="rating" name="rating" required>
                                                    <option value="1" {{ $review->rating == 1 ? 'selected' : '' }}>1
                                                        Star</option>
                                                    <option value="2" {{ $review->rating == 2 ? 'selected' : '' }}>2
                                                        Stars</option>
                                                    <option value="3" {{ $review->rating == 3 ? 'selected' : '' }}>3
                                                        Stars</option>
                                                    <option value="4" {{ $review->rating == 4 ? 'selected' : '' }}>4
                                                        Stars</option>
                                                    <option value="5" {{ $review->rating == 5 ? 'selected' : '' }}>5
                                                        Stars</option>
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
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

        <!-- Delete Game Modal -->
        <div class="modal fade" id="deleteGameModal" tabindex="-1" aria-labelledby="deleteGameModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteGameModalLabel">Delete Game</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this game? This action cannot be undone.
                    </div>
                    <div class="modal-footer">
                        <form action="/deleteGame/{{ $reviews[0]->game_id }}" method="POST">
                            @csrf
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('layouts.toast')
    @include('forms.createReviewForm')
@endsection


@section('footer')
    @include('layouts.footer')
@endsection
