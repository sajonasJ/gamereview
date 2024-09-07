<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

require_once app_path('Functions/ItemFunctions.php');

const HOME = '/homePage';
const MANUFACTURER_LIST = '/manufacturerListPage';
const MANUFACTURER = '/manufacturerPage';
const REVIEW = '/reviewPage';
const PAGES = 'pages';

const GET_ITEMS =
"SELECT items.name, items.ave_rating, items.review_count, manufacturers.name AS manufacturer_name, reviews.rating
FROM items, manufacturers, reviews
WHERE items.manufacturer = manufacturers.id
AND items.id = reviews.item_id";

const GET_MANUFACTURERS_LIST =
"SELECT name
FROM manufacturers";

const GET_REVIEWS =
"SELECT items.*, manufacturers.name AS manufacturer_name
FROM items, manufacturers
WHERE items.manufacturer = manufacturers.id
AND items.name = ?";


const GET_MANUFACTURER =
"SELECT items.*, manufacturers.name AS manufacturer_name
FROM items, manufacturers
WHERE items.manufacturer = manufacturers.id
AND manufacturers.name = 'Ubisoft'";


$renderHomePage = function () {
    $sql = GET_ITEMS;
    $items = DB::select($sql);
    return view(PAGES . HOME)->with('items', $items);
};


Route::get('/', $renderHomePage);
Route::get(HOME, $renderHomePage);


Route::get(MANUFACTURER_LIST, function () {
    $sql = GET_MANUFACTURERS_LIST;
    $manufacturerList = DB::select($sql);
    // dd($manufacturers);
    return view(PAGES . MANUFACTURER_LIST)->with('manufacturerList', $manufacturerList);
});


Route::get(MANUFACTURER, function () {
    $sql = GET_MANUFACTURER;
    $manufacturers = DB::select($sql);
    return view(PAGES . MANUFACTURER)->with('manufacturers', $manufacturers);
});



// Route::get(REVIEW, function () {
//     $sql = GET_REVIEWS;
//     $reviews = DB::select($sql);
//     // dd($reviews);
//     return view(PAGES . REVIEW)->with('reviews', $reviews);
// });

// In your web.php

Route::get('/item/{name}', function ($name) {
    $sql = GET_REVIEWS;
    $item = DB::select($sql, [$name]);
        // dd($item);
    return view(PAGES . REVIEW)->with('reviews', $item);
})->name('item.details');



function logMessage($message)
{
    Log::info($message);
}

// Additional routes to test the functions
Route::get('/create-item', function () {
    createItem();
    return 'Item Created';
});

Route::get('/delete-item', function () {
    deleteItem();
    return 'Item Deleted';
});

Route::get('/update-item', function () {
    updateItem();
    return 'Item Updated';
});


// function db_open()
// {
//     try {
//         $db = new PDO('sqlite:db/test.sqlite');
//         $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     } catch (PDOException $e) {
//         die("Error!: " . $e->getMessage());
//     }
//     return  $db;
// }

// Route::get('/test', function () {
//     $sql = "SELECT * FROM items";
//     $items = DB::select($sql);
//    return view()
// }
// );
// 