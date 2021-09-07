<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// homepage apis starts here
// Route::get('/getallarticles','Frontend\ArticleController@getallarticles');
Route::get('/getSingleLatestCategory','Frontend\HomePageController@getSingleLatestCategory');
Route::get('/getLatestSevenCategories','Frontend\HomePageController@getLatestSevenCategories');
Route::get('/getLatestcategoriesArticles','Frontend\HomePageController@getLatestcategoriesArticles');
Route::get('/getLatestEightArticles','Frontend\HomePageController@getLatestEightArticles');
Route::get('/getAllCategoriesArticles','Frontend\HomePageController@getAllCategoriesArticles');
Route::get('/getRandomArticles','Frontend\HomePageController@getRandomArticles');
Route::get('/getUserReviews','Frontend\HomePageController@getUserReviews');
