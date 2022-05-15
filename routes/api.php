<?php

use App\Http\Controllers\Api\AudioController;
use App\Http\Controllers\Api\LexicsController;
use App\Http\Controllers\Api\SendMailController;
use App\Http\Controllers\Api\TranslationsController;
use App\Http\Controllers\Api\TypesController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/* ADMIN ACTIONS ROUTES */
Route::group(['middleware' => ['token']], function () {
    Route::apiResource('translations', TranslationsController::class);

    Route::apiResource('words', LexicsController::class);
    Route::post('/addword2', [LexicsController::class, 'store2']);

    Route::post('edituser', [UserController::class, 'edituser']);
    Route::post('editpass', [UserController::class, 'editpass']);

    Route::post('islogin', [UserController::class, 'islogin']);
});

Route::post('authtest', [UserController::class, 'authtest']);
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);


Route::post('deafpass', [UserController::class, 'deafpass']);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('forgot-password', [UserController::class, 'forgot_password']);
Route::post('forgot-password-reset', [UserController::class, 'forgot_password_reset']);
Route::post('password-reset-confirm-code', [UserController::class, 'password_reset_confirm_code']);


Route::group(['middleware' => 'auth:api'], function () {
    Route::post('change-password', [UserController::class, 'change_password']);
});
/*Route::get('/my', function (Request $request) {
 return "This is good";
});*/

/* EVERYONE ELSE ACTIONS ROUTES */
Route::get('/types', [TypesController::class, 'index']);
Route::get('/words', [LexicsController::class, 'index']);
Route::get('/users', [UserController::class, 'index']);
Route::post('/audio_add', [AudioController::class, 'upload']);
Route::get('/send-mail', [SendMailController::class, 'create'])->name('send-mail-create');
