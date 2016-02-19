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

Route::get('/mainpage', [
	'as' => 'homepage',
	'uses'   => 'PageController@index'
]);
Route::get ('/', 'PostsController@viewnewestposts');

Route::group(['prefix' => '/admin'], function(){
	Route::get ('/addquestion/{postid}',[
		'as'    => 'admin.addquestion',
		'uses'  => 'QuestionsController@addquestion'
	]);
	Route::post('/addquestion/{postid}',[
		'as'    => 'admin.savequestion',
		'uses'  => 'QuestionsController@savequestion'
	]);
	Route::get ('/addpost',[
		'as'    => 'admin.addpost',
		'uses'  => 'PostsController@addpost'
	]);
	Route::post('/addpost',[
		'as'    => 'admin.savepost',
		'uses'  => 'PostsController@savepost'
	]);
	Route::get ('/addcourse',[
		'as'    => 'admin.addcourse',
		'uses'  => 'CoursesController@addcourse'
	]);
	Route::post('/addcourse',[
		'as'    => 'admin.savecourse',
		'uses'  => 'CoursesController@savecourse'
	]);
	Route::get ('/addanswer/{questionid}',[
		'as'    => 'admin.addanswer',
		'uses'  => 'AnswersController@addanswer'
	]);
	Route::post('/addspace/{questionid}', [
		'as'    => 'admin.addspace',
		'uses'  => 'SpacesController@savespace'
	]);
	Route::post('/editspace/{questionid}', [
		'as'    => "admin.editspace",
		'uses'  => "SpacesController@update"
	]);
	Route::post('/addsubquestion/{questionid}', [
		'as'    => 'admin.addsubquestion',
		'uses'  => 'SubquestionsController@savesubquestion'
	]);
	Route::post('/editsubquestion/{questionid}', [
		'as'    => "admin.editsubquestion",
		'uses'  => "SubquestionsController@update"
	]);
	Route::post('/addanswer/{questionid}',[
	'as'    => 'admin.saveanswer',
	'uses'  => 'AnswersController@saveanswer'
	]);
	put('/editcourse/{id}', [
		'as' => 'course.update',
		'uses' => 'CoursesController@update'
	]);
	Route::get ('/course/{courseid}', [
		'as' => 'admin.viewcourse',
		'uses' => 'CoursesController@adminviewcourse'
	]);
	Route::get ('post/{postid}/edit',[
		'as'    => 'admin.editpost',
		'uses'  => 'PostsController@edit'
	]);
	Route::get ('/post/{postid}/delete',[
		'as'    => 'admin.destroypost',
		'uses'  => 'PostsController@destroy'
	]);
	Route::get ('/question/{id}/delete',[
		'as'    => 'admin.destroyquestion',
		'uses'  => 'QuestionsController@destroy'
	]);
	Route::get ('/course/{id}/delete',[
		'as'    => 'admin.destroycourse',
		'uses'  => 'CoursesController@destroy'
	]);
});

Route::group(['prefix' => '/subadmin'], function(){
    Route::get('/',[
        'middleware' =>  'admin',
        'as'    => 'subadmin.view',
        'uses'  => 'ClassController@index'
    ]);

    Route::get('/addclass', [
        'middleware' =>  'admin',
        'as'    => 'subadmin.addclass',
        'uses'   => 'ClassController@addclass'
    ]);

    Route::post('/addclass',[
        'middleware' =>  'admin',
        'as'    => 'subadmin.saveclass',
        'uses'  => 'ClassController@saveclass'
        ]);

    Route::get('/class/{id}',[
        'middleware' =>  'admin',
        'as'    => 'subadmin.viewclass',
        'uses'  =>  'ClassController@viewclass'
    ]);

    Route::get('/class/{id}/addmembers',[
        'middleware' =>  'admin',
        'as'    => 'subadmin.addmembers',
        'uses'  =>  'ClassController@addmembers'
    ]);

    Route::post('/class/{id}/addmembers',[
        'middleware' =>  'admin',
        'as'    => 'subadmin.savemembers',
        'uses'  =>  'ClassController@savemembers'
    ]);

    Route::get('/class/{id}/delete',[
        'middleware' =>  'admin',
        'as'    => 'subadmin.deleteclass',
        'uses'  => 'ClassController@deleteclass'
    ]);
});
get('/post/{postid}', [
	'as' => 'user.viewpost',
	'uses' => 'PostsController@viewpost'
]);

get ('/question/{questionid}', [
	'as' => 'user.viewquestion',
	'uses' => 'QuestionsController@viewquestion'
]);

get ('/ajax/checkcoursetitle/{title}', [
	'as' => 'ajax.checkcoursetitle',
	'uses' => 'CoursesController@checkcoursetitle'
]);

get('/admin', [
	'as' => 'admin',
	'uses' => 'AdminController@index'
]);

// edit course {id}
get('/course/{id}/edit', [
	'as' => 'course.edit',
	'uses' => 'CoursesController@edit'
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

post('/admin/editquestion/{id}', [
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

post('/finishexam', [
	'as' => 'count.score',
	'uses' => 'DoexamsController@savescore'
]);

get('/search', [
	'as' => 'search',
	'uses' => 'PostsController@searchpostsbyhashtag'
]);

post('/checkanswer', [
	'as' => 'checkanswer',
	'uses' => 'AnswersController@checkanswer'
]);

get('/course/{courseid}', [
	'as' => 'user.viewcourse',
	'uses' => 'CoursesController@viewcourse'
]);

get('/kid', [
	'as' => 'kid.viewpost',
	'uses' => 'PostsController@kidView'
]);
get('/toeic',[
	'as' => 'toeic.viewpost',
	'uses' => 'PostsController@toeicView'
]);

get('/ajax/dic', [
	'as' => 'ajax.dic',
	'uses' => 'PageController@dic'
]);

get('/ajax/bing', [
	'as' => 'ajax.bing',
	'uses' => 'PageController@bing'
]);

get('/buy', [
	'as' => 'user.buy',
	'uses' => 'PaidsController@buy'
]);

get('/active', [
	'as' => 'user.getactive',
	'uses' => 'PaidsController@getActive'
]);

post('/active', [
	'as' => 'user.postactive',
	'uses' => 'PaidsController@postactive'
]);