<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


$renderHomePage = function (Request $request) {
    $sql = "SELECT game.id, game.name, publisher.name AS publisher_name, 
                   AVG(review.rating) AS average_rating, 
                   COUNT(review.id) AS review_count
            FROM game
            JOIN publisher ON game.publisher_id = publisher.id
            LEFT JOIN review ON game.id = review.game_id
            GROUP BY game.id, game.name, publisher.name";
    $games = DB::select($sql);


    $sortBy = $request->get('sort_by');
    $order = $request->get('order');

    if ($sortBy && $order) {
        sortGames($games, $sortBy, $order);
    }

    return view('pages/homePage')->with('games', $games);
};

$renderPublisherListPage = function () {
    $sql = "SELECT publisher.name AS publisher_name, AVG(review.rating) AS average_rating
            FROM publisher
            JOIN game ON game.publisher_id = publisher.id
            LEFT JOIN review ON game.id = review.game_id
            GROUP BY publisher.name";
    $publisherList = DB::select($sql);

    // dd($publisherList);

    return view('pages/publisherListPage')->with('publisherList', $publisherList);
};

$renderPublisherPage = function ($name) {
    $sql = "SELECT game.*, publisher.name AS publisher_name, AVG(review.rating) AS average_rating
            FROM game
            JOIN publisher ON game.publisher_id = publisher.id
            LEFT JOIN review ON game.id = review.game_id
            WHERE publisher.name = ?
            GROUP BY game.id, publisher.name";
    $publisher = DB::select($sql, [$name]);
    // dd($publisher);
    return view('pages/publisherPage')->with('publisher', $publisher);
};


$renderReviewPage = function ($id) {
    $sql = "SELECT game.id AS game_id, game.name, game.description, game.publisher_id, 
    review.id AS id, review.user_id, review.rating, review.review, review.created_at, 
    publisher.name AS publisher_name, user.username
    FROM game
    JOIN publisher ON game.publisher_id = publisher.id
    LEFT JOIN review ON game.id = review.game_id
    LEFT JOIN user ON review.user_id = user.id
    WHERE game.id = ?
    ORDER BY review.created_at DESC";

    $reviews = DB::select($sql, [$id]);
    // dd($reviews);
    return view('pages/reviewPage')->with('reviews', $reviews);
};

$renderCreateItemForm = function (Request $request) {
    $validationResult = validateGameForm($request);

    if ($validationResult !== true) {
        return redirect()->back()->with('error', $validationResult);
    }

    $game_name = $request->input('game_name');
    $publisher_name = $request->input('publisher_name');
    $description = $request->input('game_description');

    $existingGame = DB::select('SELECT * FROM game WHERE name = ?', [$game_name]);

    if ($existingGame) {
        return redirect()->back()->with('error', 'Game already exists.');
    }

    $publisher = DB::select('SELECT * FROM publisher WHERE name = ?', [$publisher_name]);

    if (!$publisher) {
        $publisher_id = add_publisher($publisher_name);
        if (!$publisher_id) {
            return redirect()->back()->with('error', 'Error adding publisher.');
        }
    } else {
        $publisher_id = $publisher[0]->id;
    }

    $game_id = add_game($game_name, $description, $publisher_id);
    if ($game_id) {
        return redirect("reviewPage/$game_id")->with('success', 'Game added successfully!');
    } else {
        return redirect()->back()->with('error', 'Error adding game.');
    }
};

$renderCreateReviewForm = function(Request $request) {
    $original_username = $request->input('username');
    $username = removeNumbers($original_username);

    $username_message = '';
    if ($original_username !== $username) {
        $username_message = " The username was modified to: $username.";
    }
    session(['username' => $username]);

    // Get the username stored in the session
    $sessionUsername = session('username');
    if ($request->input('username') !== $sessionUsername) {
        return redirect()->back()->with('error', 'Username mismatch.');
    }

    $validateResult = validateReviewForm($request, $username);
    if ($validateResult !== true) {
        return redirect()->back()->with('error', $validateResult);
    }

    $game_id = $request->input('game_id');
    $review = $request->input('review');
    $rating = $request->input('rating');

    $user = DB::select('SELECT * FROM user WHERE username = ?', [$username]);
    if (!$user) {
        $user_id = add_user($username);
        if (!$user_id) {
            return redirect()->back()->with('error', 'Error adding user.');
        }
    } else {
        $user_id = $user[0]->id;
    }


    $existingReview = DB::select('SELECT * FROM review WHERE game_id = ? AND user_id = ?', [$game_id, $user_id]);
    if ($existingReview) {
        return redirect()->back()->with('error', 'You have already reviewed this game.');
    }


    $review_id = add_review($game_id, $user_id, $review, $rating);
    if ($review_id) {
        return redirect("reviewPage/$game_id")->with('success', 'Review added successfully!' . $username_message);
    } else {
        return redirect()->back()->with('error', 'Error adding review.');
    }
};

$renderUpdateReviewForm = function($id, Request $request) {
    $review = $request->input('review');
    $rating = $request->input('rating');

    $sql = "UPDATE review SET review = ?, rating = ? WHERE id = ?";
    DB::update($sql, [$review, $rating, $id]);

    return redirect()->back()->with('success', 'Review updated successfully!');
};

$renderDeleteGameForm = function($name){
    $sql = 'DELETE FROM review WHERE game_id IN (SELECT id FROM game WHERE name = ?)';
    $sql2 = 'DELETE FROM game WHERE name = ?';
    DB::delete($sql, [$name]);
    DB::delete($sql2, [$name]);

    return redirect('/')->with('success', 'Game deleted successfully!');
};
