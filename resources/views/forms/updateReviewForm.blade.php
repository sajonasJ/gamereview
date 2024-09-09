<!-- Edit Review Modal -->
<div class="modal fade" id="editReviewModal-{{ $review->id }}" tabindex="-1" aria-labelledby="editReviewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editReviewModalLabel">Edit Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/updateReviewForm/{{ $review->id }}" method="POST">
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
