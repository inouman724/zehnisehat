<?php

use Illuminate\Http\Request;


// Registeration and login apis starts here
Route::post('/register','Frontend\registerationController@register');
Route::post('login', [ 'as' => 'login', 'uses' => 'Frontend\registerationController@login']);




//-----------------------------------------------------------------------------------------//
// Passport apis starts here
Route::middleware(['auth:api'])->group(function () { 

    // THERAPIST-DASHBOARD
    Route::get('getTherapistData','Frontend\therapistApisControler@getTherapistData')->middleware('CheckIsTherapist');
    Route::get('getTherapistDashboardData','Frontend\therapistApisControler@getTherapistDashboardData')->middleware('CheckIsTherapist');
    Route::get('getTherapistPatientData','Frontend\therapistApisControler@getTherapistPatientData')->middleware('CheckIsTherapist');
    Route::get('getTherapistReviewsData','Frontend\therapistApisControler@getTherapistReviewsData')->middleware('CheckIsTherapist');
    Route::get('getTherapistGeneralData','Frontend\therapistApisControler@getTherapistGeneralDataForPortal')->middleware('CheckIsTherapist');
    Route::get('getTherapistAllSpecialitites','Frontend\therapistApisControler@getTherapistAllSpecialititesData')->middleware('CheckIsTherapist');
    Route::post('updateAllTherapistData','Frontend\therapistApisControler@updateAllTherapistData')->middleware('CheckIsTherapist');
    Route::post('updateTherapistPassword','Frontend\therapistApisControler@updateTherapistPasswordData')->middleware('CheckIsTherapist');

    
    // PATIENT-DASHBOARD
    Route::get('getPatientData','Frontend\patientApisControler@getPatientData')->middleware('CheckIsPatient');
    Route::get('getPatientAppointmentData','Frontend\patientApisControler@getPatientAppointmentData')->middleware('CheckIsPatient');
    Route::post('updatePatientInfoData','Frontend\patientApisControler@updatePatientInfoData')->middleware('CheckIsPatient');
    Route::post('updatePatientPassword','Frontend\patientApisControler@updatePatientPassword')->middleware('CheckIsPatient');
    
    
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

//-----------------------------------------------------------------------------------------//
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
Route::post('/getSingleTherapistEducation','Frontend\HomePageController@getSingleTherapistEducationData');
// BOOK APPOINTMENT
Route::post('/bookAppointment','Frontend\HomePageController@bookAppointmentData');



