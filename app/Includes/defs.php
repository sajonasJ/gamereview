<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


//Sort Games Function the & passes the array by reference = default to ascending
function sortGames(&$games, $sortBy, $order = 'asc')
{
    // Sort the $games array using usort with a custom comparison function
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

// Validation function for game form inputs
function validateGameForm(Request $request)
{
    $game_name = htmlspecialchars($request->input('game_name'));
    $publisher_name = htmlspecialchars($request->input('publisher_name'));
    $description = htmlspecialchars($request->input('game_description'));

    // Check if any required fields are missing
    if (!$game_name || !$publisher_name || !$description) {
        return 'All fields are required.';
    }

    // Validate game name length (must be between 2 and 30 characters)
    if (strlen($game_name) < 2 || strlen($game_name) > 30) {
        return 'Game name must be between 2 and 30 characters long.';
    }

    // Validate publisher name length (must be between 2 and 30 characters)
    if (strlen($publisher_name) < 2 || strlen($publisher_name) > 30) {
        return 'Publisher name must be between 2 and 30 characters long.';
    }

    // Ensure game name does not contain certain characters (- _ + ")
    if (preg_match('/[-_+"]/', $game_name)) {
        return 'Game name cannot contain the following characters: - _ + "';
    }

    // Ensure publisher name does not contain certain characters (- _ + ")
    if (preg_match('/[-_+"]/', $publisher_name)) {
        return 'Publisher name cannot contain the following characters: - _ + "';
    }

    // Validate description length (maximum 500 characters)
    if (strlen($description) > 500) {
        return 'Description is too long. Maximum length is 500 characters.';
    }
    return true;
}

// Validation function for review form inputs
function validateReviewForm(Request $request, $username)
{
    $game_id = htmlspecialchars($request->input('game_id'));
    $review = htmlspecialchars($request->input('review'));
    $rating = htmlspecialchars($request->input('rating'));

    // Check if any required fields are missing
    if (!$game_id || !$username || !$review || !$rating) {
        return 'All fields are required.';
    }

    // Validate username length (must be between 3 and 15 characters)
    if (strlen($username) < 3 || strlen($username) > 15) {
        return 'Username must be at least 3 characters long and less than 15 characters long.';
    }
    return true;
}

// Validation function for review text
function validateReviewText($review, $username)
{
    // Check if the review is too long or too short
    if (strlen($review) > 500 || strlen($review) < 3) {
        return ['flagged' => true, 'message' => 'Review must be between 3 and 500 characters.'];
    }

    // Check if the review contains a link (e.g., http, https, or www)
    if (preg_match('/(https?:\/\/|www\.)/i', $review)) {
        return ['flagged' => true, 'message' => 'Links are not allowed in the review.'];
    }

    // Check for repetitive words (e.g., the same word repeated consecutively)
    if (preg_match('/\b(\w+)\b(?:\s+\1\b){2,}/i', $review)) {
        return ['flagged' => true, 'message' => 'Repetitive language is not allowed in the review.'];
    }

    // Check for words with repeating letters anywhere in the word
    if (preg_match('/\b\w*([a-zA-Z])\1{2,}\w*\b/', $review)) {
        return ['flagged' => true, 'message' => 'Words with excessive repeated letters are not allowed in the review.'];
    }

    // Check if the same review text already exists in the database
    $duplicateReview = DB::select('SELECT * FROM review WHERE review = ?', [$review]);
    if (!empty($duplicateReview)) {
        return ['flagged' => true, 'message' => 'This exact review already exists in the system.'];
    }

    // Check if the user has been consistently giving 5-star or 0-star ratings
    $userRatings = DB::select(
        'SELECT rating FROM review WHERE user_id = (SELECT id FROM user WHERE username = ?)',
        [$username]
    );

    if (count($userRatings) >= 4) {
        $allFives = array_reduce($userRatings, fn($carry, $item) => $carry && ($item->rating == 5), true);
        $allOnes = array_reduce($userRatings, fn($carry, $item) => $carry && ($item->rating == 1), true);

        if ($allFives || $allOnes) {
            return ['flagged' => true, 'message' => 'You have been giving only extreme ratings (either all 5 stars or all 0 stars). Please consider a more balanced rating.'];
        }
    }

    return ['flagged' => false, 'message' => ''];
}


// Function to replace numbers from a string
function removeNumbers($username)
{
    return preg_replace('/[0-9]+/', '', $username);
}

// Function to add a new user to the database, returns the user ID
function add_user($username)
{
    $sql = "INSERT INTO user (username) VALUES (?)";
    DB::insert($sql, [$username]);
    return DB::getPdo()->lastInsertId();
}

// Function to add a new review to the database, returns the review ID
function add_review($game_id, $user_id, $review, $rating, $flagged)
{
    $sql = "INSERT INTO review (game_id, user_id, review, rating, flagged) VALUES (?, ?, ?, ?, ?)";
    DB::insert($sql, [$game_id, $user_id, $review, $rating, $flagged]);
    return DB::getPdo()->lastInsertId();
}

// Function to add a new game to the database, returns the game ID
function add_game($name, $description, $publisher_id)
{
    $sql = "INSERT INTO game (name, description, publisher_id) VALUES (?, ?, ?)";
    DB::insert($sql, [$name, $description, $publisher_id]);
    return DB::getPdo()->lastInsertId();
}

// Function to add a new publisher to the database, returns the publisher ID
function add_publisher($name)
{
    $sql = "INSERT INTO publisher (name) VALUES (?)";
    DB::insert($sql, [$name]);
    return DB::getPdo()->lastInsertId();
}
