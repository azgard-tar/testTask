<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;
use App\Models\employee;

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

// rename model's name ( dumpautoload )

Route::get('/',                       [LoginController::class, 'login'        ] );
Route::get('/login',                  [LoginController::class, 'authenticate' ] )->name('login');

Route::group([ 'middleware' => ['auth'] ], function() {
    Route::get('/logout',             [LoginController::class, 'logout'       ] );
});

Route::group([ 'middleware' => ['auth'], "prefix" => "employees" ], function() {
    Route::get( '/',                  [EmployeeController::class, 'show'      ] )->name('employees');
    Route::get( '/delete/{id}',       [EmployeeController::class, 'delete'    ] );
    Route::get( '/add',               [EmployeeController::class, 'addView'   ] );
    Route::post('/add',               [EmployeeController::class, 'add'       ] );
    Route::get( '/edit/{id}',         [EmployeeController::class, 'updateGet' ] );
    Route::put( '/edit/{id}',         [EmployeeController::class, 'update'    ] ); 
    Route::get( '/subordination/{id}',[EmployeeController::class, 'subord'    ] );
});

Route::group([ 'middleware' => ['auth'], "prefix" => "positions" ], function() {
    Route::get('/',                   [PositionController::class, 'show'      ] )->name('positions');
    Route::get('/delete/{id}',        [PositionController::class, 'delete'    ] );
    Route::get('/add',                [PositionController::class, 'addView'   ] );
    Route::post('/add',               [PositionController::class, 'add'       ] );
    Route::get('/edit/{id}',          [PositionController::class, 'getOne'    ] );
    Route::put('/edit/{id}',          [PositionController::class, 'update'    ] );
});




