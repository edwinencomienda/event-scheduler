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

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'UserController@register');
});

Route::apiResource('course', 'CourseController');
Route::apiResource('semester', 'SemesterController');
Route::apiResource('section', 'SectionController');
Route::apiResource('subject', 'SubjectController');
Route::apiResource('exam-schedule', 'ExamScheduleController');
Route::apiResource('user-subject', 'UserSubjectController');