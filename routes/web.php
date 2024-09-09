<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

require_once app_path('Functions/ItemFunctions.php');

$renderHomePage = function () {
    $sql = "SELECT game.id, game.name, publisher.name AS publisher_name, 
                   AVG(review.rating) AS average_rating, 
                   COUNT(review.id) AS review_count
            FROM game
            JOIN publisher ON game.publisher_id = publisher.id
            LEFT JOIN review ON game.id = review.game_id
            GROUP BY game.id, game.name, publisher.name";
    $games = DB::select($sql);
    // dd($games);
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
    $sql = "SELECT game.*, review.*, publisher.name AS publisher_name, user.username
            FROM game
            JOIN publisher ON game.publisher_id = publisher.id
            LEFT JOIN review ON game.id = review.game_id
            LEFT JOIN user ON review.user_id = user.id
            WHERE game.name = ?";
    $reviews = DB::select($sql, [$name]);
    // dd($reviews);
    return view('pages/reviewPage')->with('reviews', $reviews);
});

Route::post('/createItemForm', function (Request $request) {
    $validated = $request->validate([
        'game_name' => 'required|string|max:255',
        'publisher_id' => 'required|integer',
        'game_description' => 'required|string|max:500'
    ]);

    DB::table('game')->insert([
        'name' => $validated['game_name'],
        'publisher_id' => $validated['publisher_id'],
        'description' => $validated['game_description'],
    ]);


    return redirect()->back()->with('success', 'Game added successfully!');
});

Route::post('/createReviewForm', function (Request $request) {

    $validated = $request->validate([
        'game_id' => 'required|integer',
        'username' => 'required|string|min:3|max:20|regex:/^[a-zA-Z0-9._]+$/',
        'review' => 'required|string|max:500',
        'rating' => 'required|integer|min:1|max:5',
    ]);

    $user = DB::table('user')->where('username', $validated['username'])->first();


    if (!$user) {
        $user_id = DB::table('user')->insertGetId([
            'username' => $validated['username']
        ]);
    } else {

        $user_id = $user->id;
    }

    $existingReview = DB::table('review')
        ->where('game_id', $validated['game_id'])
        ->where('user_id', $user_id)
        ->first();

    if ($existingReview) {
        return redirect()->back()->with('error', 'You have already reviewed this game.');
    }


    DB::table('review')->insert([
        'game_id' => $validated['game_id'],
        'user_id' => $user_id,
        'review' => $validated['review'],
        'rating' => $validated['rating'],
    ]);

    return redirect()->back()->with('success', 'Review added successfully!');
});
