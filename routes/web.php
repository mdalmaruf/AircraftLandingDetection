<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersController;



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
    return redirect()->action([HomeController::class, 'index']);
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/user', [UsersController::class, 'index'])->name('user.index');
Route::get('/prediction', [\App\Http\Controllers\PredictionController::class, 'index'])->name('prediction.index');
Route::post('/ml_input/train', [\App\Http\Controllers\PredictionController::class, 'ml_input_train'])->name('prediction.ml_input_train');
Route::post('/ml_input/test', [\App\Http\Controllers\PredictionController::class, 'ml_input_test'])->name('prediction.ml_input_test');

Route::get('/googlemap', [\App\Http\Controllers\PredictionController::class, 'gmap_landingdata'])->name('prediction.gmap_landingdata');

Route::get('/singlemap', [\App\Http\Controllers\PredictionController::class, 'single_landingdata'])->name('prediction.single_landingdata');

// Route::get('/user.get_data',[UserController::class, 'get_data'])->name('get_data');
Route::resource('users', UsersController::class);
