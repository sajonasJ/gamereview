<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Function to sort the $games array by a specified field ($sortBy) in either ascending ('asc') or descending ('desc') order.
// The & allows in-place modification.
function sortGames(&$games, $sortBy, $order = 'asc')
{

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

// Validation function for review form inputs
function validateReviewForm(Request $request, $username)
{
    $game_id = $request->input('id');
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