<!-- Add Review Modal -->
<div class="modal fade" id="addReviewModal" tabindex="-1" aria-labelledby="addReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addReviewModalLabel">Add a New Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add Review Form -->
                <form action="/createReviewForm" method="POST">
                    @csrf
                    <input type="hidden" name="game_id" value="{{ $reviews[0]->game_id }}">
                    
                    @if(session('username'))
                        <!-- Username is already stored in the session -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{ session('username') }}" readonly>
                        </div>
                    @else
                        <!-- Username is not in the session, ask for it -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your name" required>
                        </div>
                    @endif
                    
                    <div class="mb-3">
                        <label for="review" class="form-label">Review</label>
                        <textarea class="form-control" id="review" name="review" rows="3" placeholder="Enter your review" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating</label>
                        <select class="form-select" id="rating" name="rating" required>
                            <option value="1">1 Star</option>
                            <option value="2">2 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="5">5 Stars</option>
                        </select>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
