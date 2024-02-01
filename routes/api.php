<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RejectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/v1/user', function (Request $request) {
//     return $request->user();
// });
Route::prefix('v1')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [AuthController::class, 'profile']);
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::controller(RejectController::class)->group(function () {
            Route::post('/store-reject', 'storeReject');
            Route::get('/reject/{id}', 'show');
            Route::get('/reject', 'index');
        });
    });
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});
