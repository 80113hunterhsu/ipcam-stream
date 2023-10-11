<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoFrameController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});
Route::get('/recv', function () {
    return view('recv');
});
Route::get('/send', function () {
    return view('send');
});

Route::post('/stream', [VideoFrameController::class, 'receiveFrame']);
Route::get('/stream', [VideoFrameController::class, 'getFrame']);
Route::get('/streamdata', [VideoFrameController::class, 'index']);