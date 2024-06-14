<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route pour se connecter
Route::post('/login', 'App\Http\Controllers\Api\UserController@loginOrCreate');

// Route pour tester la clé d'API NotchPay
Route::middleware('auth:sanctum')->post('/test-api-key', 'App\Http\Controllers\Api\NotchPayController@testApiKey');

// Route pour initialiser une transaction
Route::middleware('auth:sanctum')->post('/init-transaction', 'App\Http\Controllers\Api\NotchPayController@initTransac');

// Route pour initialiser une transaction
Route::middleware('auth:sanctum')->post('/init-transfert', 'App\Http\Controllers\Api\NotchPayController@initTransferts');

// Route pour vérifier l'état d'une transaction
Route::middleware('auth:sanctum')->post('/verify-transaction/{ref}', 'App\Http\Controllers\Api\NotchPayController@verifiedTransac');

// Route pour confirmer un paiement
Route::middleware('auth:sanctum')->post('/confirm-payment/{ref}', 'App\Http\Controllers\Api\NotchPayController@confirmPay');

// Route pour confirmer un transfert
Route::middleware('auth:sanctum')->post('/confirm-transfert/{ref}', 'App\Http\Controllers\Api\NotchPayController@confirmTransfert');

// Route pour annuler une transaction
Route::middleware('auth:sanctum')->post('/cancel-payment/{ref}', 'App\Http\Controllers\Api\NotchPayController@cancelPay');