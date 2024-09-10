<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//function that selects the required data for the home page
$renderHomePage = function (Request $request) {
    $sql = "SELECT game.id, game.name, publisher.name AS publisher_name, 
                   AVG(review.rating) AS average_rating, 
                   COUNT(review.id) AS review_count
            FROM game
            JOIN publisher ON game.publisher_id = publisher.id
            LEFT JOIN review ON game.id = review.game_id
            GROUP BY game.id, game.name, publisher.name";
    $games = DB::select($sql);

    //if sort_by and order are set, sort the games array
    $sortBy = $request->get('sort_by');
    $order = $request->get('order');
    if ($sortBy && $order) {
        sortGames($games, $sortBy, $order);
    }
    return view('pages/homePage')->with('games', $games);
};

// function that selects the required data for the publisher list page
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

// function that selects the required data for the publisher page
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

// function that selects the required data for the review page
$renderReviewPage = function ($id) {
    $sql = "SELECT game.id AS game_id, game.name, game.description, game.publisher_id, 
    review.id AS id, review.user_id, review.rating, review.review, review.created_at, review.flagged,
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

// function that selects the required data for the review edit page
$renderCreateItemForm = function (Request $request) {

    //validates the input fields
    $validationResult = validateGameForm($request);
    if ($validationResult !== true) {
        return redirect()->back()->with('error', $validationResult);
    }

    $game_name = htmlspecialchars($request->input('game_name'));
    $publisher_name = htmlspecialchars($request->input('publisher_name'));
    $description = htmlspecialchars($request->input('game_description'));

    //checks if the game already exists
    $existingGame = DB::select('SELECT * FROM game WHERE name = ?', [$game_name]);
    if ($existingGame) {
        return redirect()->back()->with('error', 'Game already exists.');
    }

    //checks the published if exists if not adds it, returns the publisher id
    $publisher = DB::select('SELECT * FROM publisher WHERE name = ?', [$publisher_name]);
    if (!$publisher) {
        $publisher_id = add_publisher($publisher_name);
        if (!$publisher_id) {
            return redirect()->back()->with('error', 'Error adding publisher.');
        }
    } else {
        $publisher_id = $publisher[0]->id;
    }

    //adds the game to the database
    $game_id = add_game($game_name, $description, $publisher_id);
    if ($game_id) {
        return redirect("reviewPage/$game_id")->with('success', 'Game added successfully!');
    } else {
        return redirect()->back()->with('error', 'Error adding game.');
    }
};

// function that selects the required data for the review edit page
$renderCreateReviewForm = function (Request $request) {
    $original_username = htmlspecialchars($request->input('username'));

    //replaces numbers from the username
    $username = removeNumbers($original_username);

    //function to display an altered username message
    $username_message = '';
    if ($original_username !== $username) {
        $username_message = " The username was modified to: $username.";
    }

    // Retrieve the current session username
    $sessionUsername = session('username');

    // If the session username is already set, compare it with the input username
    if ($sessionUsername !== null) {
        if (htmlspecialchars($request->input('username')) !== $sessionUsername) {
            return redirect()->back()->with('error', 'Username mismatch.');
        }
    } else {
        // If the session username is not set, store the input username in the session
        session(['username' => $username]);
    }

    // Validate the review form
    $validateResult = validateReviewForm($request, $username);
    if ($validateResult !== true) {
        return redirect()->back()->with('error', $validateResult);
    }

    $game_id = htmlspecialchars($request->input('game_id'));
    $review = htmlspecialchars($request->input('review'));
    $rating = htmlspecialchars($request->input('rating'));

    // Validate the review text
    $validation = validateReviewText($review, $username);
    //?THIS WILL STOP THE FAKE REVIEW FROM BEING ADDED
    // if ($validation['flagged']) {
    //     return redirect()->back()->with('error', $validation['message']);
    // }

    // Check if the user exists in the database
    $user = DB::select('SELECT * FROM user WHERE username = ?', [$username]);
    if (!$user) {
        // Add the user if not found
        $user_id = add_user($username);
        if (!$user_id) {
            return redirect()->back()->with('error', 'Error adding user.');
        }
    } else {
        $user_id = $user[0]->id;
    }

    // Check if the user has already reviewed this game
    $existingReview = DB::select('SELECT * FROM review WHERE game_id = ? AND user_id = ?', [$game_id, $user_id]);
    if ($existingReview) {
        return redirect()->back()->with('error', 'You have already reviewed this game.');
    }

    // Add the review to the database, even if flagged
    $review_id = add_review($game_id, $user_id, $review, $rating, $validation['flagged']);
    if ($review_id) {
        $message = 'Review added successfully!' . $username_message;

        // Append the validation message if the review was flagged
        if ($validation['flagged']) {
            $message .= ' Note: ' . $validation['message'];
        }

        return redirect("reviewPage/$game_id")->with('success', $message);
    } else {
        return redirect()->back()->with('error', 'Error adding review.');
    }
};


// function that selects the required data for the review edit page
$renderUpdateReviewForm = function ($id, Request $request) {
    $review = htmlspecialchars($request->input('review'));
    $rating = htmlspecialchars($request->input('rating'));

    $sql = "UPDATE review SET review = ?, rating = ? WHERE id = ?";
    DB::update($sql, [$review, $rating, $id]);

    return redirect()->back()->with('success', 'Review updated successfully!');
};

//function that deletes the reviews first before deleting the game
$renderDeleteGameForm = function ($name) {
    $sql = 'DELETE FROM review WHERE game_id IN (SELECT id FROM game WHERE name = ?)';
    $sql2 = 'DELETE FROM game WHERE name = ?';
    DB::delete($sql, [$name]);
    DB::delete($sql2, [$name]);

    return redirect('/')->with('success', 'Game deleted successfully!');
};
