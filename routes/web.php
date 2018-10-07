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

Route::resource('/', 'IndexController', [
    'only' => ['index'],
    'names' => [
        'index' => 'home'
    ]
]);

Route::resource('portfolios', 'PortfolioController', [
    'parameters' => [
        'portfolios' => 'alias'
    ]

]);

Route::resource('articles', 'ArticleController', [
    'parameters' => [
        'articles' => 'alias'
    ]
]);

Route::get('articles/cat/{cat_alias?}', ['uses' => 'ArticleController@index', 'as' => 'articlesCat'])
    ->where('cat_alias', '[\w-]+');

Route::resource('comments', 'CommentController', [
    'only' => ['store']
]);

Route::match(['get', 'post'], 'contacts', ['uses' => 'ContactController@index', 'as' => 'contacts']);

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

    Route::get('/', ['uses' => 'Admin\IndexController@index', 'as' => 'adminIndex']);

    Route::resource('articles', 'Admin\ArticleController', ['as' => 'admin']);
    Route::post('articles/{article}/fix', ['uses' => 'Admin\ArticleController@fix', 'as' => 'articlesFix']);

    Route::resource('permissions', 'Admin\PermissionController', ['as' => 'admin']);
    Route::resource('menus', 'Admin\MenuController', ['as' => 'admin']);
    Route::resource('users', 'Admin\UserController', ['as' => 'admin']);
    Route::resource('portfolios', 'Admin\PortfolioController', ['as' => 'admin']);
    Route::resource('sliders', 'Admin\SliderController', ['as' => 'admin']);
});