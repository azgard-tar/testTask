<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position_Model;
use App\Models\Employee_Model;
use Illuminate\Support\Facades\Validator;

class PositionController extends Controller
{
    public function show(){
        return view('positions/list',['positions' => Position_Model::all()]);
    }
    public function getOne($id){
        $posit = Position_Model::find($id);
        if (!is_null($posit))
            return  view('positions/edit',['position' => $posit]);
        else
            return view('positions/edit',["errors" => ["Position was not found"]]);
    }
    public function delete($id){
        $posit = Position_Model::find($id);
        if( ! is_null($posit) ){
            Employee_Model::where('id_position',$posit->id)->update(['id_position' => 1]);
            $posit->delete();
            return redirect()->route('positions');
        }
        else{
            return view('positions/list', ["error"=>"Position was not found"]);
        }
    }

    public function addView(){
        return view('positions/add');
    }

    public function add(Request $request){
        $validator = Validator::make($request->all(),[
            "title" => "required|string|max:256|min:2"
        ]);
        if ($validator->fails()){
            return view('positions/add', ['errors' => $validator->errors()->toArray()]);
        }
        $data = $request->except(['id']);
        $data['created_at'] = date(config('app.date_format_db'));
        $data['updated_at'] = date(config('app.date_format_db'));
        $data['admin_created_id'] = auth()->user()->id;
        $data['admin_updated_id'] = auth()->user()->id;
        $position = Position_Model::create($data);
        $position->save();
        return redirect()->route("positions");
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "title" => "required|string|max:256|min:2"
        ]);
        $error = null;
        $position = Position_Model::find($id);
        if ($validator->fails())
            $error = ['errors' => $validator->errors()->toArray()];
        if( is_null( $position ) )
            $error = ["errors"=> ["Position wasn't found"]];
        if( !is_null( $error ) )
            return view("positions/add",array_merge((array)$position,(array)$error));
        
        $position->title = $request->title;
        $position->updated_at = date(config('app.date_format_db'));
        $position->admin_updated_id = auth()->user()->id;
        $position->save();
        return redirect()->route("positions");
    }
}
