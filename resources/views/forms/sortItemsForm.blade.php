<div class="d-flex justify-content-between align-items-center w-100 p-3 bg-dark text-white">

    <h3 class="mb-0 cstm-h3 fw-bold text-uppercase border-bottom border-warning pb-2">
        <i class="bi bi-controller"></i> Games List
    </h3>

    <!-- Sorting Form and Add Game Button (Right Aligned) -->
    <!-- Sorting Form and Add Game Button (Right Aligned) -->
    <div class="d-flex align-items-center">
        <!-- Sorting Form -->
        <form action="{{ url('/homePage') }}" method="GET" class="d-flex align-items-center me-3">
            <!-- Sort By Dropdown -->
            <div class="me-3 d-flex align-items-center">
                <label for="sort_by" class="form-label mb-0 me-2 text-nowrap">Sort by:</label>
                <select name="sort_by" id="sort_by" class="form-select form-select-sm" style="width: 150px;"
                    onchange="this.form.submit()">
                    <option value="">Select</option>
                    <option value="review_count" {{ request('sort_by') == 'review_count' ? 'selected' : '' }}>
                        Reviews</option>
                    <option value="average_rating" {{ request('sort_by') == 'average_rating' ? 'selected' : '' }}>
                        Rating</option>
                </select>
            </div>

            <!-- Order Dropdown -->
            <div class="me-3 d-flex align-items-center">
                <label for="order" class="form-label mb-0 me-2 text-nowrap">Order:</label>
                <select name="order" id="order" class="form-select form-select-sm" style="width: 150px;"
                    onchange="this.form.submit()">
                    <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Descending</option>
                </select>
            </div>
        </form>

        <!-- Add Game Button -->
        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#addGameModal"
            style="height: 34px;">
            Add Game
        </button>
    </div>

</div>