<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConfigurationController;

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


# Configuration Routes
// Country Routes
Route::get('country/provinces', [App\Http\Controllers\ConfigurationController::class, 'country_provinces'])->middleware('auth')->name('country.provinces');

Route::any('country',
[
    'uses'=>'App\Http\Controllers\ConfigurationController@country',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['Country'],
    'roles'=>['Read']
]
)->name('country.index');

Route::any('country/filter',
[
    'uses'=>'App\Http\Controllers\ConfigurationController@filter_country',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['Country'],
    'roles'=>['Read']
]
)->name('country.filter');

Route::post('country/store',
[
    'uses'=>'App\Http\Controllers\ConfigurationController@store_country',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['Country'],
    'roles'=>['Create']
]
)->name('country.store');

Route::post('country/update',
[
    'uses'=>'App\Http\Controllers\ConfigurationController@update_country',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['Country'],
    'roles'=>['Update']
]
)->name('country.update');

Route::delete('country/delete',
[
    'uses'=>'App\Http\Controllers\ConfigurationController@delete_country',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['Country'],
    'roles'=>['Delete']
]
)->name('country.delete');

// Province Routes
Route::get('province/districts', [App\Http\Controllers\ConfigurationController::class, 'province_districts'])->middleware('auth')->name('province.districts');

Route::any('province',
[
    'uses'=>'App\Http\Controllers\ConfigurationController@province',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['Province'],
    'roles'=>['Read']
]
)->name('province.index');

Route::any('province/filter',
[
    'uses'=>'App\Http\Controllers\ConfigurationController@filter_province',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['Province'],
    'roles'=>['Read']
]
)->name('province.filter');

Route::post('province/store',
[
    'uses'=>'App\Http\Controllers\ConfigurationController@store_province',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['Province'],
    'roles'=>['Create']
]
)->name('province.store');

Route::post('province/update',
[
    'uses'=>'App\Http\Controllers\ConfigurationController@update_province',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['Province'],
    'roles'=>['Update']
]
)->name('province.update');

Route::delete('province/delete',
[
    'uses'=>'App\Http\Controllers\ConfigurationController@delete_province',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['Province'],
    'roles'=>['Delete']
]
)->name('province.delete');

// District Routes
Route::any('district',
[
    'uses'=>'App\Http\Controllers\ConfigurationController@district',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['District'],
    'roles'=>['Read']
]
)->name('district.index');

Route::any('district/filter',
[
    'uses'=>'App\Http\Controllers\ConfigurationController@filter_district',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['District'],
    'roles'=>['Read']
]
)->name('district.filter');

Route::post('district/store',
[
    'uses'=>'App\Http\Controllers\ConfigurationController@store_district',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['District'],
    'roles'=>['Create']
]
)->name('district.store');

Route::post('district/update',
[
    'uses'=>'App\Http\Controllers\ConfigurationController@update_district',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['District'],
    'roles'=>['Update']
]
)->name('district.update');

Route::delete('district/delete',
[
    'uses'=>'App\Http\Controllers\ConfigurationController@delete_district',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['District'],
    'roles'=>['Delete']
]
)->name('district.delete');

// Village Routes
Route::any('village',
[
    'uses'=>'App\Http\Controllers\ConfigurationController@village',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['Village'],
    'roles'=>['Read']
]
)->name('village.index');

Route::any('village/filter',
[
    'uses'=>'App\Http\Controllers\ConfigurationController@filter_village',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['Village'],
    'roles'=>['Read']
]
)->name('village.filter');

Route::post('village/store',
[
    'uses'=>'App\Http\Controllers\ConfigurationController@store_village',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['Village'],
    'roles'=>['Create']
]
)->name('village.store');

Route::post('village/update',
[
    'uses'=>'App\Http\Controllers\ConfigurationController@update_village',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['Village'],
    'roles'=>['Update']
]
)->name('village.update');

Route::delete('village/delete',
[
    'uses'=>'App\Http\Controllers\ConfigurationController@delete_village',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['Village'],
    'roles'=>['Delete']
]
)->name('village.delete');
# End Configuration Routes

# Donor Routes
Route::any('donor',
[
    'uses'=>'App\Http\Controllers\DonorController@donor',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['Donors'],
    'roles'=>['Read']
]
)->name('donor.index');

Route::any('donor/filter',
[
    'uses'=>'App\Http\Controllers\DonorController@filter_donor',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['Donors'],
    'roles'=>['Read']
]
)->name('donor.filter');

Route::post('donor/store',
[
    'uses'=>'App\Http\Controllers\DonorController@store_donor',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['Donors'],
    'roles'=>['Create']
]
)->name('donor.store');

Route::post('donor/update',
[
    'uses'=>'App\Http\Controllers\DonorController@update_donor',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['Donors'],
    'roles'=>['Update']
]
)->name('donor.update');

Route::delete('donor/delete',
[
    'uses'=>'App\Http\Controllers\DonorController@delete_donor',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['Donors'],
    'roles'=>['Delete']
]
)->name('donor.delete');
# End Donor Routes

# Ministries Routes
Route::any('ministry',
[
    'uses'=>'App\Http\Controllers\MinistryController@ministry',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['Ministries'],
    'roles'=>['Read']
]
)->name('ministry.index');

Route::any('ministry/filter',
[
    'uses'=>'App\Http\Controllers\MinistryController@filter_ministry',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['Ministries'],
    'roles'=>['Read']
]
)->name('ministry.filter');

Route::post('ministry/store',
[
    'uses'=>'App\Http\Controllers\MinistryController@store_ministry',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['Ministries'],
    'roles'=>['Create']
]
)->name('ministry.store');

Route::post('ministry/update',
[
    'uses'=>'App\Http\Controllers\MinistryController@update_ministry',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['Ministries'],
    'roles'=>['Update']
]
)->name('ministry.update');

Route::delete('ministry/delete',
[
    'uses'=>'App\Http\Controllers\MinistryController@delete_ministry',
    'middleware'=>['accessDomains','auth','roles'],
    'access_domains'=>['Ministries'],
    'roles'=>['Delete']
]
)->name('ministry.delete');
# End Ministries Routes
