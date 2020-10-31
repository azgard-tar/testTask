<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;

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
    Route::get('/employeesList', function () {
        return view('employeesList', [ 'check' => true ]);
    })->name('employees');
    Route::get('/positions', function () {
        return view('positionsList', [ 'check' => true ]);
    })->name('positions');
    Route::get('/logout', [LoginController::class, 'logout'] );
});

Route::get('/login', [LoginController::class, 'authenticate'] );
