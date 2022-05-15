<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LexicsController;
use App\Http\Controllers\TranslationsController;
use App\Http\Controllers\TypesController;
use Illuminate\Support\Facades\Route;

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

//Route::resource('transaltions', TranslationsController::class);
//Route::resource('lexics', LexicsController::class);
//Route::resource('types', TypesController::class);


Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/dashboard', [DashboardController::class, 'index']);
//Route::get('/', 'DashboardController@index');
Route::get('/', function () {
    //return view('welcome');
   return view('policies/dictionnaire_tabwa/index');
});

Route::get('/privacy', function () {
    return view('policies/dictionnaire_tabwa/index');
});
