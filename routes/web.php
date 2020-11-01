<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmployeeController;
use App\Htpp\Controllers\PositionController;

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

Route::middleware(['auth'])->group( function() {
    Route::get('/employeesList', function(){
        return view('employeesList', (new EmployeeController)->show() );
    })->name('employees');
    Route::get('/positions', function () {
        return view('positionsList',(new \App\Http\Controllers\PositionController)->show());
    })->name('positions');
    Route::get('/logout', [LoginController::class, 'logout'] );
    Route::get('/employees/delete/{id}', function($id){
        (new EmployeeController)->delete($id);
        return redirect()->route('employees');
    });
    Route::get('/employees/add', function(){
        return view("employeeAdd",(new EmployeeController)->getAddData());
    });
    Route::post('/employees/add', function(Request $request){
        $response = (new EmployeeController)->add($request);
        if( ! $response->status ){
            return view("employeeAdd",(object) array_merge((array)$response,(array)(new EmployeeController)->getAddData()));
        }
        return view("employeesList", (new EmployeeController)->show() );
    });
});

Route::get('/login', [LoginController::class, 'authenticate'] );
