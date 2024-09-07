<?php

use Illuminate\Support\Facades\Log;

require_once app_path('Functions/ItemFunctions.php');

const HOME = '/homePage';
const MANUFACTURER_LIST = '/manufacturerListPage';
const MANUFACTURER = '/manufacturerPage';
const REVIEW = '/reviewPage';
const PAGES = 'pages';

$gameData = [
    'Ubisoft' => [
        'Assassins Creed Valhalla',
        'Far Cry 6',
        'The Crew Motorfest',
        'Assassins Creed Mirage',
        'Skull and Bones',
        'Star Wars Outlaws'
    ],
    'Activision Blizzard' => [
        'World of Warcraft',
        'Diablo III',
        'StarCraft',
        'Diablo',
        'Diablo II',
        'Warcraft III'
    ],
    'Riot Games' => [
        'League of Legends',
        'Teamfight Tactics',
        'Valorant',
        'League of Legends Wild Rift'
    ]
];



use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view(PAGES . HOME);
});
Route::get(HOME, function () {
    return view(PAGES . HOME);
});

Route::get(MANUFACTURER_LIST, function () {
    return view(PAGES . MANUFACTURER_LIST);
});

Route::get(MANUFACTURER, function () {
    return view(PAGES . MANUFACTURER);
});
Route::get(REVIEW, function () {
    return view(PAGES . REVIEW);
});


function logMessage($message)
{
    Log::info($message);
}

// Additional routes to test the functions
Route::get('/create-item', function () {
    createItem();  // Function from ItemFunctions.php
    return 'Item Created';
});

Route::get('/delete-item', function () {
    deleteItem();  // Function from ItemFunctions.php
    return 'Item Deleted';
});

Route::get('/update-item', function () {
    updateItem();  // Function from ItemFunctions.php
    return 'Item Updated';
});
