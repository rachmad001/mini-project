<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\ClientApi;
use App\Http\Controllers\ProjectApi;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('client')->group(function() {
    Route::get('/', [ClientApi::class, 'index']);
});

Route::prefix('project')->group(function() {
    Route::post('/', [ProjectApi::class, 'add']);
    Route::put('/', [ProjectApi::class, 'edit']);
    Route::get('/', [ProjectApi::class, 'index']);
    Route::get('/filter', [ProjectApi::class, 'filter']);
    Route::delete('/', [ProjectApi::class, 'delete']);
});