<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;

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

Route::middleware(['auth:api'])->group( function() {
    Route::post('/employees/add', [EmployeeController::class, 'add'] ); // C
    Route::get('/employees', function(){
        return response()->json( (new EmployeeController)->show(), 200 );
    } ); // R
    Route::get('/employees/{id}', function($id){
        $response = (new EmployeeController)->getOne($id);
        return response()->json( $response[0], $response[1] );
    } ); 
    Route::put('/employees/edit/{id}', [EmployeeController::class, 'update'] ); // U
    Route::delete('/employees/delete/{id}', [EmployeeController::class, 'delete'] ); // D

    Route::post('/positions/add', [PositionController::class, 'add'] ); // C
    Route::get('/positions', [PositionController::class, 'show'] ); // R
    Route::get('/positions/{id}', [PositionController::class, 'getOne'] ); 
    Route::put('/positions/edit/{id}', [PositionController::class, 'update'] ); // U
    Route::delete('/positions/delete/{id}', [PositionController::class, 'delete'] ); // D
});
