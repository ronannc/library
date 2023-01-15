<?php

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
Route::middleware( 'auth:sanctum' )->group( function () {
    Route::resource( 'books', \App\Http\Controllers\BookController::class )->except( [ 'create', 'edit', 'show' ] );
} );
Route::post( '/auth/token', [ \App\Http\Controllers\UserController::class, 'auth' ] );
Route::post( '/user', [ \App\Http\Controllers\UserController::class, 'store' ] );
