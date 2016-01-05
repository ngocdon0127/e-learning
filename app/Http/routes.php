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
get('/auth/facebook', [
    'as' => 'login.facebook',
    'uses' => 'Auth\AuthController@redirectToProvider'
]);

get('/auth/google', [
    'as' => 'login.google',
    'uses' => 'Auth\AuthController@googleRedirectToProvider'
]);

Route::controllers(['/auth' => 'Auth\AuthController', 'password' => 'Auth\PasswordController',]);
Route::get ('/', 'PostsController@viewnewestposts');


Route::get ('/admin/addquestion/{postid}', 'QuestionsController@addquestion');
Route::post('/admin/addquestion/{postid}', 'QuestionsController@savequestion');
Route::get ('/admin/addpost', 'PostsController@addpost');
Route::post('/admin/addpost', 'PostsController@savepost');
Route::get ('/admin/addcourse', 'CoursesController@addcourse');
Route::post('/admin/addcourse', 'CoursesController@savecourse');
Route::get ('/admin/addanswer/{postid}', 'AnswersController@addanswer');
Route::post('/admin/addanswer/{postid}', 'AnswersController@saveanswer');
Route::get ('/course/{courseid}', 'CoursesController@viewcourse');
Route::get ('/post/{postid}', 'PostsController@viewpost');
Route::get ('/question/{questionid}', 'QuestionsController@viewquestion');
Route::get ('/ajax/checkcoursetitle/{title}', 'CoursesController@checkcoursetitle');


get('/admin', [
    'as' => 'admin',
    'uses' => 'AdminController@index'
]);

// edit course {id}
get('/course/{id}/edit', [
    'as' => 'course.edit',
    'uses' => 'CoursesController@edit'
]);

put('/admin/editcourse/{id}', [
    'as' => 'course.update',
    'uses' => 'CoursesController@update'
]);

// edit post {id}
get('/post/{id}/edit', [
    'as' => 'post.edit',
    'uses' => 'PostsController@edit'
]);

put('/admin/editpost/{id}', [
    'as' => 'post.update',
    'uses' => 'PostsController@update'
]);

// edit question {id} (Question + Description)
get('question/{id}/edit', [
    'as' => 'question.edit',
    'uses' => 'QuestionsController@edit'
]);

put('/admin/editquestion/{id}', [
    'as' => 'question.update',
    'uses' => 'QuestionsController@update'
]);

// edit question {id} (Answers) // Will merge with 2 above routes later.
get('/answer/{questionid}/edit', [
    'as' => 'answer.edit',
    'uses' => 'AnswersController@edit'
]);

put('/admin/editanswer/{questionid}', [
    'as' => 'answer.update',
    'uses' => 'AnswersController@update'
]);

// delete question {id}
delete('/question/{id}/delete', [
    'as' => 'question.destroy',
    'uses' => 'QuestionsController@destroy'
]);

//temporary route
Route::get ('/admin/post/{postid}/edit', 'PostsController@edit');
Route::get ('/admin/post/{postid}/delete', 'PostsController@destroy');
Route::get ('/admin/question/{id}/delete', 'QuestionsController@destroy');
Route::get ('/admin/course/{id}/delete', 'CoursesController@destroy');

get('/fbcallback', [
    'as' => 'callback.facebook',
    'uses' => 'Auth\AuthController@handleProviderCallback'
]);

get('/ggcallback', [
    'as' => 'callback.google',
    'uses' => 'Auth\AuthController@googleHandleProviderCallback'
]);

post('/timeonline', [
    'as' => 'count.timeonline',
    'uses' => 'TimesController@incTimeOnline'
]);

post('/trackip', [
    'as' => 'count.ip',
    'uses' => 'TimesController@trackip'
]);

get('/br', [
    'as' => 'count.br',
    'uses' => 'TimesController@br'
]);