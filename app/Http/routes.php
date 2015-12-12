<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
Route::controllers(['auth' => 'Auth\AuthController', 'password' => 'Auth\PasswordController',]);
Route::get('/', 'CoursesController@viewallcourses');
Route::get('/admin/addquestion/{postid}', 'QuestionsController@addquestion');
Route::post('/admin/addquestion/{postid}', 'QuestionsController@savequestion');
Route::get('/admin/addpost', 'PostsController@addpost');
Route::post('/admin/addpost', 'PostsController@savepost');
Route::get('/admin/addcourse', 'CoursesController@addcourse');
Route::post('/admin/addcourse', 'CoursesController@savecourse');
Route::get('/admin/addanswer/{postid}', 'AnswersController@addanswer');
Route::post('/admin/addanswer/{postid}', 'AnswersController@saveanswer');
Route::get('/course/{courseid}', 'CoursesController@viewcourse');
Route::get('/post/{postid}', 'PostsController@viewpost');
Route::get('/question/{questionid}', 'QuestionsController@viewquestion');
Route::get('/ajax/checkcoursetitle/{title}', 'CoursesController@checkcoursetitle');
