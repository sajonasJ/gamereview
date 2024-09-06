<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('homePage');
});

Route::get('/manufacturerListPage', function () {
    return view('manufacturerListPage');
});

Route::get('/manufacturerPage', function () {
    return view('manufacturerPage');
});
Route::get('/reviewPage', function () {
    return view('reviewPage');
});
