<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('ID/{id}', function ($id) {
    echo $id;
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/post/{slug}', 'PostController@post')->name('home.post');

//Route::get('/post/{id}',['as'=>'home.post','PostController@post']);

/*Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');*/
Route::resource('members','MemberController');
Route::group(['middleware'=>'auth'],function(){

	
	Route::resource('articles','ArticleController');
	Route::resource('posts','PostController');
	Route::resource('medias','MediaController');
	Route::resource('comments','CommentsController');
	Route::resource('comment/replies','CommentRepliesController');
	Route::delete('/delete/media','MediaController@deleteMedia');

	Route::post('comment/reply', 'CommentRepliesController@createReply')->name('comment.reply');

});


