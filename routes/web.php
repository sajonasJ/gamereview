<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


// Function to sort the $games array by a specified field ($sortBy) in either ascending ('asc') or descending ('desc') order.
// The & allows in-place modification.
function sortGames(&$games, $sortBy, $order = 'asc')
{
    // The function compares two objects ($a and $b) based on the value of $sortBy.
    usort($games, function ($a, $b) use ($sortBy, $order) {
        if ($a->$sortBy == $b->$sortBy) {
            return 0;
        }
        if ($order === 'asc') {
            return ($a->$sortBy < $b->$sortBy) ? -1 : 1;
        } else {
            return ($a->$sortBy > $b->$sortBy) ? -1 : 1;
        }
    });
}


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


Route::get('/', $renderHomePage);
Route::get('/homePage', $renderHomePage);
Route::get('/publisherListPage', function () {
    $sql = "SELECT publisher.name AS publisher_name, AVG(review.rating) AS average_rating
            FROM publisher
            JOIN game ON game.publisher_id = publisher.id
            LEFT JOIN review ON game.id = review.game_id
            GROUP BY publisher.name";
    $publisherList = DB::select($sql);

    // dd($publisherList);

    return view('pages/publisherListPage')->with('publisherList', $publisherList);
});




Route::get('/publisherPage/{name}', function ($name) {
    $sql = "SELECT game.*, publisher.name AS publisher_name, AVG(review.rating) AS average_rating
            FROM game
            JOIN publisher ON game.publisher_id = publisher.id
            LEFT JOIN review ON game.id = review.game_id
            WHERE publisher.name = ?
            GROUP BY game.id, publisher.name";
    $publisher = DB::select($sql, [$name]);
    // dd($publisher);
    return view('pages/publisherPage')->with('publisher', $publisher);
})->name('publisher.details');



Route::get('/reviewPage/{id}', function ($id) {
    $sql = "SELECT game.*, review.*, publisher.name AS publisher_name, user.username
    FROM game
    JOIN publisher ON game.publisher_id = publisher.id
    LEFT JOIN review ON game.id = review.game_id
    LEFT JOIN user ON review.user_id = user.id
    WHERE game.id = ?
    ORDER BY review.created_at DESC";
    $reviews = DB::select($sql, [$id]);
    // dd($reviews);
    return view('pages/reviewPage')->with('reviews', $reviews);
});

Route::post('/createItemForm', function (Request $request) {
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
});

function validateGameForm(Request $request)
{
    $game_name = $request->input('game_name');
    $publisher_name = $request->input('publisher_name');
    $description = $request->input('game_description');

    if (!$game_name || !$publisher_name || !$description) {
        return 'All fields are required.';
    }
    if (strlen($game_name) < 2 || strlen($game_name) > 30) {
        return 'Game name must be between 2 and 30 characters long.';
    }
    if (strlen($publisher_name) < 2 || strlen($publisher_name) > 30) {
        return 'Publisher name must be between 2 and 30 characters long.';
    }
    if (preg_match('/[-_+"]/', $game_name)) {
        return 'Game name cannot contain the following characters: - _ + "';
    }
    if (preg_match('/[-_+"]/', $publisher_name)) {
        return 'Publisher name cannot contain the following characters: - _ + "';
    }
    if (strlen($description) > 500) {
        return 'Description is too long. Maximum length is 500 characters.';
    }
    return true;
}

function add_game($name, $description, $publisher_id)
{
    $sql = "INSERT INTO game (name, description, publisher_id) VALUES (?, ?, ?)";
    DB::insert($sql, [$name, $description, $publisher_id]);
    return DB::getPdo()->lastInsertId();
}

function add_publisher($name)
{
    $sql = "INSERT INTO publisher (name) VALUES (?)";
    DB::insert($sql, [$name]);
    return DB::getPdo()->lastInsertId();
}


Route::post('/createReviewForm', function (Request $request) {
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
});

// Validation function for review form inputs
function validateReviewForm(Request $request, $username)
{
    $game_id = $request->input('game_id');
    $review = $request->input('review');
    $rating = $request->input('rating');

    if (!$game_id || !$username || !$review || !$rating) {
        return 'All fields are required.';
    }
    if (strlen($username) < 3 || strlen($username) > 15) {
        return 'Username must be at least 3 characters long and less than 15 characters long.';
    }
    return true;
}

function removeNumbers($username)
{
    return preg_replace('/[0-9]+/', '', $username);
}

function add_user($username)
{
    $sql = "INSERT INTO user (username) VALUES (?)";
    DB::insert($sql, [$username]);
    return DB::getPdo()->lastInsertId();
}

function add_review($game_id, $user_id, $review, $rating)
{
    $sql = "INSERT INTO review (game_id, user_id, review, rating) VALUES (?, ?, ?, ?)";
    DB::insert($sql, [$game_id, $user_id, $review, $rating]);
    return DB::getPdo()->lastInsertId();
}


Route::post('/updateReviewForm/{id}', function ($id, Request $request) {
    $review = $request->input('review');
    $rating = $request->input('rating');

    $sql = "UPDATE review SET review = ?, rating = ? WHERE id = ?";
    DB::update($sql, [$review, $rating, $id]);

    return redirect()->back()->with('success', 'Review updated successfully!');
});

Route::post('/deleteGameForm/{name}', function ($name) {
    $sql = 'DELETE FROM review WHERE game_id IN (SELECT id FROM game WHERE name = ?)';
    $sql2 = 'DELETE FROM game WHERE name = ?';
    DB::delete($sql, [$name]);
    DB::delete($sql2, [$name]);

    return redirect('/')->with('success', 'Game deleted successfully!');
});
