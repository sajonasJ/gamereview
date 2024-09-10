<?php

require_once app_path('Includes/defs.php');
require_once app_path('Includes/functionRoutes.php');

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::get('/', $renderHomePage);

Route::get('/homePage', $renderHomePage);

Route::get('/publisherListPage', $renderPublisherListPage);

Route::get('/publisherPage/{name}', $renderPublisherPage);

Route::get('/reviewPage/{id}', $renderReviewPage);

Route::post('/createItemForm', $renderCreateItemForm );

Route::post('/createReviewForm',$renderCreateReviewForm);


Route::post('/updateReviewForm/{id}',$renderUpdateReviewForm);

Route::post('/deleteGameForm/{name}', $renderDeleteGameForm);
