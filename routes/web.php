<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//--------------------------posts----------------------------------------------------
//display
 Route::get('/posts', 'PostController@index')->name('posts.index');//display all data
 Route::get('/posts/create', 'PostController@create')->name('posts.create');//add new
 Route::post('/posts/store', 'PostController@store')->name('posts.store'); //post for create add new

Route::get('/posts/{id}', 'PostController@show')->name('posts.show');//display data with $id
// add new


//edit
Route::get('/posts/{id}/edit', 'PostController@edit')->name('posts.edit');//get data for edit with $id
Route::put('/posts/{id}/update', 'PostController@update')->name('posts.update'); //post for edit
//delete
Route::delete('/posts/{id}/destroy', 'PostController@destroy')->name('posts.destroy'); //delete with $id

//-----------------------get masterdata-----------------------------------
//Route::get('getmasterdata',[PostController::class,'getmasterdata']);
Route::get('getmasterdata','PostController@getmasterdata')->name('masterdata');
