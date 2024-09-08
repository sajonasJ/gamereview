<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

require_once app_path('Functions/ItemFunctions.php');

$renderHomePage = function () {
    $sql = "SELECT game.id, game.name, publisher.name AS publisher_name
            FROM game, publisher
            WHERE game.publisher_id = publisher.id";
    $games = DB::select($sql);
    // dd($game);
    return view('pages/homePage')->with('games', $games);
};

Route::get('/', $renderHomePage);
Route::get('/homePage', $renderHomePage);

Route::get('/publisherListPage', function () {
    $sql = "SELECT name
            FROM publisher";
    $publisherList = DB::select($sql);
    // dd($publisherList);
    return view('pages/publisherListPage')->with('publisherList', $publisherList);
});




Route::get('/publisherPage/{name}', function ($name) {
    $sql = "SELECT game.*, publisher.name AS publisher_name
            FROM game, publisher
            WHERE game.publisher_id = publisher.id
            AND publisher.name = ?";
    $publisher = DB::select($sql, [$name]);
    // dd($publisher);
    return view('pages/publisherPage')->with('publisher', $publisher);
})->name('publisher.details');


Route::get('/reviewPage/{name}', function ($name) {
    $sql = "SELECT game.*, publisher.name AS publisher_name, review.rating, review.review, user.username
            FROM game
            JOIN publisher ON game.publisher_id = publisher.id
            LEFT JOIN review ON game.id = review.game_id
            LEFT JOIN user ON review.user_id = user.id
            WHERE game.name = ?";
    $reviews = DB::select($sql, [$name]);


    return view('pages/reviewPage')->with('reviews', $reviews);
});

// Function to add a new game (using route for form submission)
Route::post('/createItemForm', function (Request $request) {
    // Validate the request data
    $validated = $request->validate([
        'game_name' => 'required|string|max:255',
        'publisher_id' => 'required|integer',
        'game_description' => 'required|string',
        'rating' => 'required|integer|min:1|max:5',
    ]);

    // Insert the new game into the database
    DB::table('game')->insert([
        'name' => $validated['game_name'],
        'publisher_id' => $validated['publisher_id'],
        'description' => $validated['game_description'],
    ]);

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Game added successfully!');
});

Route::post('/createReviewForm', function (Request $request) {
    // Validate the request data
    $validated = $request->validate([
        'game_id' => 'required|integer',
        'username' => 'required|string|max:255',
        'review' => 'required|string|max:500',
        'rating' => 'required|integer|min:1|max:5',
    ]);

    // Insert the new review into the database
    DB::table('review')->insert([
        'game_id' => $validated['game_id'],
        'username' => $validated['username'],
        'review' => $validated['review'],
        'rating' => $validated['rating'],
    ]);

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Review added successfully!');
});