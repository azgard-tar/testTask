<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\employee;

class EmployeeController extends Controller
{
    public function show(){
        return view('employeesList', [ 'employees' => employee::all() ]);
    }
}
