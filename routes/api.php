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
Route::apiResource('user', 'UserController');
Route::apiResource('make-up-class', 'MakeUpClassController');
Route::apiResource('activity', 'MakeUpClassController');

Route::group(['prefix' => 'file'], function () {
    Route::get('download', 'FileController@export');
    Route::post('import/students', 'FileController@importStudents');
});

Route::group(['prefix' => 'admin'], function () {
    Route::post('approve/user-request', 'AdminController@approveUserRequest');
});
