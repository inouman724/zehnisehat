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

Route::middleware(['auth:api'])->group(function () { 
    Route::post('getPatientData','Frontend\patientApisControler@getPatientData')->middleware('CheckIsPatient');



    // ADMIN-DASHBOARD
    Route::get('getAdminDashboard','Admin\adminApisController@getAdminDashboardData')->middleware('CheckIsAdmin');
    Route::get('getAllAppointments','Admin\adminApisController@getAllAppointmentsData')->middleware('CheckIsAdmin');
    Route::get('getAllSpecialitites','Admin\adminApisController@getAllSpecialititesData')->middleware('CheckIsAdmin');
    Route::get('getAdminAllTherapists','Admin\adminApisController@getAllTherapistsData')->middleware('CheckIsAdmin');
    Route::get('getAdminAllPatients','Admin\adminApisController@getAllPatientsData')->middleware('CheckIsAdmin');
    Route::get('getAdminAllReviews','Admin\adminApisController@getAllReviewsData')->middleware('CheckIsAdmin');
    Route::get('getAdminProfile','Admin\adminApisController@getAdminProfileData')->middleware('CheckIsAdmin');
    Route::post('registerNewTherapist','Admin\adminApisController@registerNewTherapistData')->middleware('CheckIsAdmin');
    Route::post('adminChangeSpeciality','Admin\adminApisController@radminChangeSpecialityData')->middleware('CheckIsAdmin');
    Route::post('adminAddNewSpeciality','Admin\adminApisController@addNewSpecialityData')->middleware('CheckIsAdmin');
    Route::post('getTherapistDataById','Admin\adminApisController@getTherapistDataByIdData')->middleware('CheckIsAdmin');
    Route::post('adminAddTherapistLoginInfo','Admin\adminApisController@adminAddTherapistLoginInfoData')->middleware('CheckIsAdmin');
    Route::post('getTherapistGeneralInfo','Admin\adminApisController@getTherapistGeneralData')->middleware('CheckIsAdmin');
    Route::post('adminAddTherapistGeneralInfo','Admin\adminApisController@adminAddTherapistGeneralInfoData')->middleware('CheckIsAdmin');
    Route::post('getTherapistBioInfo','Admin\adminApisController@getTherapistBioData')->middleware('CheckIsAdmin');
    Route::post('adminAddTherapistBioInfo','Admin\adminApisController@adminAddTherapistBioInfoData')->middleware('CheckIsAdmin');
    Route::post('getTherapistEducationInfo','Admin\adminApisController@getTherapistEducationData')->middleware('CheckIsAdmin');
    Route::post('adminAddTherapistEducationInfo','Admin\adminApisController@adminAddTherapistEducationInfoData')->middleware('CheckIsAdmin');
    Route::post('getTherapistWorkInfo','Admin\adminApisController@getTherapistWorkData')->middleware('CheckIsAdmin');
    Route::post('adminAddTherapistWorkInfo','Admin\adminApisController@adminAddTherapistWorkInfoData')->middleware('CheckIsAdmin');









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
Route::post('/getSingleArticle','Frontend\HomePageController@getSingleArticle');
Route::post('/getSingleCategoryArticles','Frontend\HomePageController@getSingleCategoryArticles');


// SINGLE THERAPIST
Route::post('/getSingleTherapist','Frontend\HomePageController@getSingleTherapistData');

//-----------------------------------------------------------------------------------------//
// Patient Apis starts here
// Route::post('getPatientAppointments','Frontend\patientApisControler@getPatientAppointments');


Route::middleware(['CheckRole'])->group(function(){
 
    Route::post('home', 'Frontend\registerationController@home');
    
});

