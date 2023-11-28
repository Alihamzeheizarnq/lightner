<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\MessageController;
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

Route::group([
    'prefix' => 'v1/auth',
], function ($router) {
    $router->post('login', [AuthController::class, 'login']);
    $router->post('verify', [AuthController::class, 'verify']);
    $router->post('logout', [AuthController::class, 'logout']);
    $router->post('refresh', [AuthController::class, 'refresh']);
    $router->get('me', [AuthController::class, 'me']);
});


Route::group([
    'middleware' => ['auth'],
    'prefix' => 'v1',
], function ($router) {
    $router->apiResource('messages' , MessageController::class);
});
