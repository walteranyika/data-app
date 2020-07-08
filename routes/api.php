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
