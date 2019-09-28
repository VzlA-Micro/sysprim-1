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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// User module routes
Route::get('/users/register', function() {
    return view('register');
})->name('users.register');

// Companies module routes
Route::get('/companies/register', function() {
    return view('register');
})->name('companies/register');