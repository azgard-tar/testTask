<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\position;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
{
    public function show(){
        return response()->json( ['positions' => position::all()], 200);
    }
    public function getOne($id){
        return response()->json( ['position' => position::find($id)->get() ], 200 );
    }
    public function delete($id){
        $empl = position::find($id);
        if( ! is_null($empl) ){
            $empl->delete();
            return response()->json(203,null);
        }
        else{
            return response()->json(["error"=>"Position was not found"],404);
        }
    }

    public function add(){

    }

    public function update($id){
        
    }
}
