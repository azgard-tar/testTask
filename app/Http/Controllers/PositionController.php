<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\position;
use App\Models\employee;
use Illuminate\Support\Facades\Validator;

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
            employee::where('id_position',$posit->id)->update(['id_position' => 1]);
            $posit->delete();
            return ["error" => null, "code" => 203];
        }
        else{
            return ["error"=>"Position was not found","code" => 404];
        }
    }

    public function add(Request $request){
        $validator = Validator::make($request->all(),[
            "title" => "required|string|max:256|min:2"
        ]);
        if ($validator->fails()){
            return (object)['status' => false, 'errors' => $validator->errors()->toArray()];
        }
        $data = $request->except(['id']);
        $data['created_at'] = date(config('app.date_format_db'));
        $data['updated_at'] = date(config('app.date_format_db'));
        $data['admin_created_id'] = auth()->user()->id;
        $data['admin_updated_id'] = auth()->user()->id;
        $position = position::create($data);
        $position->save();
        return (object)['status' => true];
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "title" => "required|string|max:256|min:2"
        ]);
        if ($validator->fails()){
            return (object)['status' => false, 'errors' => $validator->errors()->toArray()];
        }
        $position = position::find($id);
        if(!is_null($position)){
            $position->title = $request->title;
            $position->updated_at = date(config('app.date_format_db'));
            $position->admin_updated_id = auth()->user()->id;
            $position->save();
            return (object)['status' => true];
        }
        
        return (object)['status' => false,"errors"=>["Position wasn't found"]];
    }
}
