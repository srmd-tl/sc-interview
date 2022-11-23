<?php

use App\Http\Controllers\TollController;
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

Route::middleware( 'auth:sanctum' )->get( '/user', function ( Request $request ) {
    return $request->user();
} );


Route::post( 'entry', [ TollController::class, 'entry' ] )->name( 'tool.entry' );
Route::post( 'exit', [ TollController::class, 'exit' ] )->name( 'tool.exit' );
Route::put( 'toll/{toll}/update', [ TollController::class, 'update' ] )->name( 'tool.update' );
