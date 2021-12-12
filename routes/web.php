<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
    return redirect(route('login'));
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

# User Management Routes
Auth::routes(['register'=>false]);

Route::get('profile', [App\Http\Controllers\UserController::class, 'profile'])->middleware('auth')->name('profile');
Route::post('change_password', [App\Http\Controllers\UserController::class, 'change_password'])->middleware('auth')->name('change-user-password');

Route::get('user-create',
    [
        'uses'=>'App\Http\Controllers\UserController@create',
        'middleware'=>['accessDomains','auth','roles'],
        'access_domains'=>['Register New User'],
        'roles'=>['Create']
    ]
)->name('create-user');

Route::any('user-store',
    [
        'uses'=>'App\Http\Controllers\UserController@store',
        'middleware'=>['accessDomains','auth','roles'],
        'access_domains'=>['Register New User'],
        'roles'=>['Create']
    ]
)->name('user-store');

Route::any('user-show',
    [
        'uses'=>'App\Http\Controllers\UserController@show',
        'middleware'=>['accessDomains','auth','roles'],
        'access_domains'=>['All Users'],
        'roles'=>['Read']
    ]
)->name('user-show');

Route::any('user-change-permission',

    [
        'uses'=>'App\Http\Controllers\UserController@change_permission',
        'middleware'=>['accessDomains','auth','roles'],
        'access_domains'=>['All Users'],
        'roles'=>['Create']
    ]

)->name('change-permission');

Route::any('reset-password',
    [
        'uses'=>'App\Http\Controllers\UserController@reset_password',
        'middleware'=>['accessDomains','auth','roles'],
        'access_domains'=>['All Users'],
        'roles'=>['Create']
    ]
)->name('change-password');

Route::delete('user-delete/{email}',
    [
        'uses'=>'App\Http\Controllers\UserController@destroy',
        'middleware'=>['accessDomains','auth','roles'],
        'access_domains'=>['All Users'],
        'roles'=>['Delete']
    ]
)->name('user-delete');

Route::get('user-jobs',
    [
        'uses'=>'App\Http\Controllers\UserController@jobs',
        'middleware'=>['accessDomains','auth','roles'],
        'access_domains'=>['User Jobs'],
        'roles'=>['Read']
    ]
)->name('user.jobs');

Route::post('user-jobs-store',
    [
        'uses'=>'App\Http\Controllers\UserController@store_jobs',
        'middleware'=>['accessDomains','auth','roles'],
        'access_domains'=>['User Jobs'],
        'roles'=>['Create']
    ]
)->name('user.jobs.store');

Route::post('user-jobs-update',
    [
        'uses'=>'App\Http\Controllers\UserController@update_jobs',
        'middleware'=>['accessDomains','auth','roles'],
        'access_domains'=>['User Jobs'],
        'roles'=>['Update']
    ]
)->name('user.jobs.update');

Route::delete('user-jobs-delete',
    [
        'uses'=>'App\Http\Controllers\UserController@delete_jobs',
        'middleware'=>['accessDomains','auth','roles'],
        'access_domains'=>['User Jobs'],
        'roles'=>['Delete']
    ]
)->name('user.jobs.delete');
# End User Management Routes
