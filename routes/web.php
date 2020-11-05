<?php

use App\Http\Controllers\Ajax\EventsController;
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

Route::prefix('ajax')->group(function () {
    Route::post('/save-event', [EventsController::class, 'save']);
});

Route::get('/', function () {
    return view('app');
});
