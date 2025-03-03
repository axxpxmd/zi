<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {
    // Dashboard
    Route::get('dashboard/{tahun_id}', 'DashboardController@index')->name('dashboard');

    // Profile
    Route::namespace('Profile')->group(function () {
        Route::resource('profile', 'ProfileController');
        Route::get('profile/{id}/edit-password', 'ProfileController@editPassword')->name('profile.editPassword');
        Route::post('profile/{id}/update-password', 'ProfileController@updatePassword')->name('profile.updatePassword');
    });

    // Master Roles
    Route::prefix('master-roles')->namespace('MasterRole')->name('master-role.')->group(function () {
        // Role
        Route::resource('role', 'RoleController');
        Route::prefix('role')->name('role.')->group(function () {
            Route::post('api', 'RoleController@api')->name('api');
            Route::get('{id}/addPermissions', 'RoleController@permission')->name('addPermissions');
            Route::post('storePermissions', 'RoleController@storePermission')->name('storePermissions');
            Route::get('{id}/getPermissions', 'RoleController@getPermissions')->name('getPermissions');
            Route::delete('{name}/destroyPermission', 'RoleController@destroyPermission')->name('destroyPermission');
        });
        // Permission
        Route::resource('permission', 'PermissionController');
        Route::post('permission/api', 'PermissionController@api')->name('permission.api');
    });

    // Pengguna
    Route::namespace('Pengguna')->group(function () {
        Route::resource('pengguna', 'PenggunaController');
        Route::post('pengguna/api', 'PenggunaController@api')->name('pengguna.api');
        Route::get('pengguna/edit-password/{id}', 'PenggunaController@editPassword')->name('pengguna.editPassword');
        Route::post('pengguna/update-password/{id}', 'PenggunaController@updatePassword')->name('pengguna.updatePassword');
        Route::get('pengguna/delete-verifikator-tempat/{id}', 'PenggunaController@deleteVerifikatorTempat')->name('pengguna.deleteVerifikatorTempat');
        Route::get('pengguna/show/get-perangkat-daerah', 'PenggunaController@getPerangkatDaerah')->name('pengguna.getPerangkatDaerah');
    });

    // Master Data
    Route::namespace('MasterData')->group(function () {
        // Waktu
        Route::resource('waktu', 'TimeController');
        Route::post('waktu/api', 'TimeController@api')->name('waktu.api');

        // Unit Kerja
        Route::resource('unit-kerja', 'UnitKerjaController');
        Route::post('unit-kerja/api', 'UnitKerjaController@api')->name('unit-kerja.api');

        // BAB
        Route::resource('bab', 'BabController');
        Route::post('bab/api', 'BabController@api')->name('bab.api');
    });

    // Pengungkit
    Route::namespace('Pengungkit')->group(function () {
        // indikator 1
        Route::resource('pengungkit-indikator-1', 'PengungkitIndikator1Controller');
        Route::post('pengungkit-indikator-1/api', 'PengungkitIndikator1Controller@api')->name('pengungkit-indikator-1.api');
    });
});
