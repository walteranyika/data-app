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
//ssh root@66.228.55.80

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/fetch/user/info','YouthController@getYouth');//
Route::post('/submit/user/info','YouthController@saveYouth');//

Route::post('/login','UsersLoginController@userLogin');//
Route::post('/get/user/reports','AnswersController@getAnswers');//
Route::post('/submit/questions/info','AnswersController@save');
Route::post('/fetch/questions','QuestionsController@getQuestions');//

Route::get('reports/totalShujas', 'ReportsController@totalShujas');
Route::get('reports/totalShujasPerWard', 'ReportsController@totalShujasPerWard');
Route::get('reports/totalShujasPerSchool', 'ReportsController@totalShujasPerSchool');
Route::get('reports/totalShujasPerSubCounty', 'ReportsController@totalShujasPerSubCounty');
Route::get('reports/totalShujasPerCounty', 'ReportsController@totalShujasPerCounty');
Route::get('reports/totalCollectionPerSeal', 'ReportsController@totalCollectionPerSeal');
Route::get('reports/totalsByAge', 'ReportsController@totalsByAge');

Route::get('reports/count/youths', 'ReportsController@youth_count');

Route::any('data/capture', 'ReportsController@capture');
