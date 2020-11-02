<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\position;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
{
    public function show(){
        return ['positions' => position::all(), "code" => 200];
    }
    public function getOne($id){
        $posit = position::find($id);
        if (!is_null($posit)){
            return ['status' => true, 'position' => $posit, "code" => 200];
        }
        else
        return (object)[
            'status' => false, 
            "errors" => ["Position was not found"], 
            "code" => 404
        ];
    }
    public function delete($id){
        $posit = position::find($id);
        if( ! is_null($posit) ){
            $posit->delete();
            return ["error" => null, "code" => 203];
        }
        else{
            return ["error"=>"Position was not found","code" => 404];
        }
    }

    public function add(){

    }

    public function update($id){
        
    }
}
