<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\position;
use App\Models\employee;
use Illuminate\Support\Facades\Validator;

class PositionController extends Controller
{
    public function show(){
        return view('positionsList',['positions' => position::all()]);
    }
    public function getOne($id){
        $posit = position::find($id);
        if (!is_null($posit))
            return  view('positionEdit',['position' => $posit]);
        else
            return view('positionEdit',["errors" => ["Position was not found"]]);
    }
    public function delete($id){
        $posit = position::find($id);
        if( ! is_null($posit) ){
            employee::where('id_position',$posit->id)->update(['id_position' => 1]);
            $posit->delete();
            return redirect()->route('positions');
        }
        else{
            return view('positionsList', ["error"=>"Position was not found"]);
        }
    }

    public function addView(){
        return view('positionAdd');
    }

    public function add(Request $request){
        $validator = Validator::make($request->all(),[
            "title" => "required|string|max:256|min:2"
        ]);
        if ($validator->fails()){
            return view('positionAdd', ['errors' => $validator->errors()->toArray()]);
        }
        $data = $request->except(['id']);
        $data['created_at'] = date(config('app.date_format_db'));
        $data['updated_at'] = date(config('app.date_format_db'));
        $data['admin_created_id'] = auth()->user()->id;
        $data['admin_updated_id'] = auth()->user()->id;
        $position = position::create($data);
        $position->save();
        return redirect()->route("positions");
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "title" => "required|string|max:256|min:2"
        ]);
        $error = null;
        $position = position::find($id);
        if ($validator->fails())
            $error = ['errors' => $validator->errors()->toArray()];
        if( is_null( $position ) )
            $error = ["errors"=> ["Position wasn't found"]];
        if( !is_null( $error ) )
            return view("positionAdd",array_merge((array)$position,(array)$error));
        
        $position->title = $request->title;
        $position->updated_at = date(config('app.date_format_db'));
        $position->admin_updated_id = auth()->user()->id;
        $position->save();
        return redirect()->route("positions");
    }
}
