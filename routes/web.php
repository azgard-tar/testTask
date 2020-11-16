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

Route::get('/', function () {
    if( Auth::check() )
        return redirect()->route('employees');
    else
        return view('auth');
});

Route::group([ 'middleware' => ['auth'] ], function() { // add prefix
    // Employee
    Route::get( '/employees',                   [EmployeeController::class, 'show'      ] )->name('employees');
    Route::get( '/employees/delete/{id}',       [EmployeeController::class, 'delete'    ] );
    Route::get( '/employees/add',               [EmployeeController::class, 'getAddData'] );
    Route::post('/employees/add',               [EmployeeController::class, 'add'       ] );
    Route::get( '/employees/edit/{id}',         [EmployeeController::class, 'updateGet' ] );
    Route::put( '/employees/edit/{id}',         [EmployeeController::class, 'update'    ] ); 
    Route::get( '/employee/subordination/{id}', [EmployeeController::class, 'subord'    ] );

    // Position
    Route::get('/positions', [PositionController::class, 'show'    ])->name('positions');
    Route::get('/positions/delete/{id}', function($id){
        (new PositionController)->delete($id);
        return redirect()->route('positions');
    });
    Route::get('/positions/add', function(){
        return view("positionAdd");
    });
    Route::post('/positions/add', function(Request $request){
        $response = (new PositionController)->add($request);
        if( ! $response->status ){
            return view("positionAdd",(array)$response);
        }
        return redirect()->route("positions");
    });
    Route::get('/positions/edit/{id}', function($id){
        return view("positionEdit", (new PositionController)->getOne($id), );
    });
    Route::put('/positions/edit/{id}', function(Request $request, $id){
        $response = (new PositionController)->update($request, $id);
        if( ! $response->status ){
            return view("positionEdit",array_merge(
                (array)(new PositionController)->getOne($id),
                (array)$response
            ));
        }
        return redirect()->route("positions");
    });

    // Other
    Route::get('/logout', [LoginController::class, 'logout'] );


});

Route::get('/login', [LoginController::class, 'authenticate'] )->name('login');
