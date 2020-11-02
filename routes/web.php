<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;

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
        return view('positionsList',(new PositionController)->show());
    })->name('positions');
    Route::get('/logout', [LoginController::class, 'logout'] );
    Route::get('/employees/delete/{id}', function($id){
        (new EmployeeController)->delete($id);
        return redirect()->route('employees');
    });
    Route::get('/positions/delete/{id}', function($id){
        (new PositionController)->delete($id);
        return redirect()->route('positions');
    });
    Route::get('/employees/add', function(){
        return view("employeeAdd",(new EmployeeController)->getAddData());
    });
    Route::post('/employees/add', function(Request $request){
        $response = (new EmployeeController)->add($request);
        if( ! $response->status ){
            return view("employeeAdd",(object) array_merge((array)$response,(array)(new EmployeeController)->getAddData()));
        }
        return redirect()->route("employees");
    });

    Route::get('/employees/edit/{id}', function($id){
        return view("employeeEdit",array_merge(
            (array)(new EmployeeController)->getOne($id), 
            (array)(new EmployeeController)->getAddData()
        ));
    });

    Route::put('/employees/edit/{id}', function(Request $request, $id){
        $response = (new EmployeeController)->update($request, $id);
        if( ! $response->status ){
            return view("employeeEdit",array_merge(
                (array)(new EmployeeController)->getOne($id), 
                (array)(new EmployeeController)->getAddData(),
                (array)$response
            ));
        }
        return redirect()->route("employees");
    });

    Route::get('/positions/add', function(){
        return view("positionAdd");
    });
    Route::post('/positions/add', function(Request $request){
        // $response = (new PositionController)->add($request);
        // if( ! $response->status ){
        //     return view("positionAdd",(object)$response);
        // }
        // return redirect()->route("positions");
    });

    Route::get('/positions/edit/{id}', function($id){
        return view("positionEdit", (new PositionController)->getOne($id), );
    });

    Route::put('/positions/edit/{id}', function(Request $request, $id){
        // $response = (new PositionController)->update($request, $id);
        // if( ! $response->status ){
        //     return view("positionEdit",array_merge(
        //         (array)(new PositionController)->getOne($id),
        //         (array)$response
        //     ));
        // }
        // return redirect()->route("positions");
    });


});

Route::get('/login', [LoginController::class, 'authenticate'] )->name('login');
