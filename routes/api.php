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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     // return $request->user();
//     Route::post('getPatientAppointments','Frontend\patientApisControler@getPatientAppointments');

// });
// Registeration and login apis starts here
Route::post('/register','Frontend\registerationController@register');
// Route::post('/login','Frontend\registerationController@login');
Route::post('login', [ 'as' => 'login', 'uses' => 'Frontend\registerationController@login']);

Route::middleware(['auth:api','CheckIsPatient'])->group(function () { 

    // Route::post('getPatientAppointments','Frontend\patientApisControler@getPatientAppointments')->middleware('CheckIsPatient');
    Route::post('getPatientAppointments','Frontend\patientApisControler@getPatientAppointments');

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
Route::get('/getAllTherapists','Frontend\HomePageController@getAllTherapists');
Route::get('/getLatest9Categories','Frontend\HomePageController@getLatest9Categories');
Route::get('/getAllArticles','Frontend\HomePageController@getAllArticles');

//-----------------------------------------------------------------------------------------//
// Patient Apis starts here
// Route::post('getPatientAppointments','Frontend\patientApisControler@getPatientAppointments');


Route::middleware(['CheckRole'])->group(function(){
 
    Route::post('home', 'Frontend\registerationController@home');
    
});

