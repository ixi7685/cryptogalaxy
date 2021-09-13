<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\PriceAlertController;

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

Route::get('/', [CurrencyController::class, 'index']);

Route::get('/{id}', [PriceAlertController::class, 'index']);

Route::post('/{id}/store', [PriceAlertController::class, 'store']);

Route::post('/{id}/{key}/edit', [PriceAlertController::class, 'edit']);

Route::post('/{id}/{key}/update', [PriceAlertController::class, 'update']);

Route::delete('/{key}/delete', [PriceAlertController::class, 'destroy']);


