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

Route::get('/', function () {
    return view('welcome');
});

Route::get('home', 'HomeController@index');
Route::get('bookmark/{token}', 'HomeController@bookmark');

// ログイン、ログアウト
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// ユーザ登録
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// 登録確認
Route::get('auth/confirm/{token}', 'Auth\AuthController@getConfirm');
Route::post('auth/confirm', 'Auth\AuthController@postConfirm');

// 登録確認メール再送信
Route::get('auth/resend', 'Auth\AuthController@getResend');
Route::post('auth/resend', 'Auth\AuthController@postResend');

// パスワードリセット
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

// パスワード管理
Route::get('pm', 'PasswordManagerController@index');
Route::get('pm/create', 'PasswordManagerController@create');
Route::get('pm/show/{id}', 'PasswordManagerController@show');
Route::get('pm/edit/{id}', 'PasswordManagerController@edit');
Route::get('pm/delete/{id}', 'PasswordManagerController@destroy');
Route::post('pm/store', 'PasswordManagerController@store');
Route::post('pm/update', 'PasswordManagerController@update');

// ファイル共有
Route::get('fm', 'FileManagerController@index');
Route::get('fm/create', 'FileManagerController@create');
Route::post('fm/store', 'FileManagerController@store');
Route::get('fm/show/{id}', 'FileManagerController@show');
Route::get('fm/delete/{id}', 'FileManagerController@destroy');
Route::get('fm/download/{token}', 'FileManagerController@getDownload');
Route::post('fm/download', 'FileManagerController@postDownload');
Route::get('download', 'FileManagerController@download');

// 地図
Route::get('map', 'MapController@index');

// プロフィール
Route::get('profile', 'ProfileController@index');
Route::get('profile/destroy', 'ProfileController@destroy');
Route::get('profile/remove', 'ProfileController@remove');
Route::post('profile/update', 'ProfileController@update');
Route::post('profile/upload', 'ProfileController@upload');
Route::post('profile/trim', 'ProfileController@trim');

// 設定
Route::get('settings', 'SettingController@index');
Route::post('settings/update', 'SettingController@update');
Route::post('settings/store', 'SettingController@store');
Route::post('settings/check', 'SettingController@check');
Route::post('settings/destroy', 'SettingController@destroy');

// フレンド
Route::get('friend', 'FriendController@index');
Route::get('friend/confirm/{token}', 'FriendController@confirm');
Route::get('friend/destroy/{id}', 'FriendController@destroy');
Route::post('friend/invite', 'FriendController@invite');

// 天気
Route::get('weather', 'WeatherController@index');
Route::get('weather/show/{lat}/{lng}', 'WeatherController@show');
