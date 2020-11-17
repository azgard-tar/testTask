<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee_Model;
use App\Models\Position_Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    public function show()
    {
        //$data = employee::select(['employees.*', 'positions.title'])->get();
        
        $data = Employee_Model::join('positions_model', 'employees_model.id_position', '=', 'positions_model.id')
            ->select('employees_model.*', 'positions_model.title')->get();
        
        return view('employees/list', ["employees" => $data, "code" => 200] );
    }
    public function getOne($id)
    {
        $empl = Employee_Model::find($id);
        if (!is_null($empl)) {
            return ['employee' => $empl];
        } else
            return ["errors" => ["Employee was not found"]];
    }
    public function delete($id)
    {
        $empl = Employee_Model::find($id);
        if (!is_null($empl)) {
            $empl->delete();
            Employee_Model::where('id_head', $empl->id)->update(['id_head' => null]);
            return redirect()->route('employees');
        } else {
            return ["errors" => ["Employee was not found"]];
        }
    }

    public function getAddData($include = null)
    {
        $employees = Employee_Model::select(['id', 'full_name'])->get();
        $positions = Position_Model::select(['id', 'title'])->get();
        if( is_null( $include ) )
            return  ["employees" => $employees, "positions" => $positions];
        else
            return  array_merge(
                        ["employees" => $employees, "positions" => $positions],
                        $include
                    );
    }

    public function addView(){
        return view("employees/add",$this->getAddData());
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "full_name" => "required|min:2|max:256|unique:employees_model",
            "phone_number" => "required|regex:/\+380\(\d{2}\)\d{7}/",
            "email" => "required|email",
            "salary" => "required|numeric|min:0|max:500000",
            "id_head" => "required|integer",
            "id_position" => "required|exists:positions_model,id"
        ]);
        if ($validator->fails()) 
            return view("employees/add", $this->getAddData( ['errors' => $validator->errors()->toArray() ]));
        
        if ($request->id_head != -1) 
            if ($this->checkSubordTree($request->id_head)['level'] == 5)
                return view("employees/add", $this->getAddData( ['errors' => ["Level of subordination is already 5."] ]));
        else
            $data['id_head'] = null;
        
        $data = $request->except(['id', 'photo']);
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        $data['admin_created_id'] = auth()->user()->id;
        $data['admin_updated_id'] = auth()->user()->id;
        
        $employee = Employee_Model::create($data);
        $array = explode('.',$request->date_of_employment);
            $employee->date_of_employment = date('Y-m-d',strtotime($array[1].'/'.$array[0].'/'.$array[2]));
        $employee->save();
        if ($request->photo) 
            (new ImageController)->uploadImage($request, $employee);

        return redirect()->route("employees");
    }

    public function checkSubordTree($id)
    {
        $empl['data'] = Employee_Model::where('id', $id)->select('id', 'full_name', 'id_head')->get();
        $data = Employee_Model::where('id_head', $id)->select('id', 'full_name', 'id_head')->get();
        $level = 0;
        if (count($data) > 0) {
            for ($i = 0; $i < count($data); $i++) {
                $empl['subords'][$i] = $this->checkSubordTree($data[$i]->id);
                if ($empl['subords'][$i]['level'] > $level)
                    $level = $empl['subords'][$i]['level'];
            }
        }
        $empl['level'] = ++$level;
        return $empl;
    }

    public function subord($id){
        return json_encode($this->checkSubordTree($id), true);
    }

    public function getUpdateData($id,$include = null){
        $employees = Employee_Model::select(['id', 'full_name'])->get();
        $positions = Position_Model::select(['id', 'title'])->get();
        if( is_null( $include ) ){
            return array_merge(
                $this->getOne($id),
                ["employees" => $employees, "positions" => $positions]
            );
        } 
        else{
            return array_merge(
                $this->getOne($id),
                ["employees" => $employees, "positions" => $positions],
                (array) $include
            );
        }
        
    }

    public function updateGet($id){
        return view("employees/edit",$this->getUpdateData($id));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "full_name" => "required|min:2|max:256",
            "phone_number" => "required|regex:/\+380\(\d{2}\)\d{7}/",
            "email" => "required|email",
            "salary" => "required|numeric|min:0|max:500000",
            "id_head" => "required|integer",
            "id_position" => "required|exists:positions_model,id"
        ]);
        $error = null;
        $empl = Employee_Model::find($id);
        if( $validator->fails() ) 
            $error = ['errors' => $validator->errors()->toArray()];
        if( $request->id_head != -1 ) {
            $levelOfSubord = $this->checkSubordTree($request->id_head)['level'];
            if ($levelOfSubord == 5)
                $error = ['errors' => ["Level of subordination is already 5."]];
            if ($levelOfSubord <= $this->checkSubordTree($id)['level'])
                $error = ['errors' => ["Level of subordination of this person( 'head' ) is too small."]]; 
        }
        if( is_null($empl) )
            $error = ['errors' => ["Employee was not found"]];
        
        if( !is_null( $error ) )
            return view("employees/edit", $this->getUpdateData($id,$error));
        

        $request->updated_at = Carbon::now();
        $request->admin_updated_id = auth()->user()->id;
        $empl->update($request->except(['id', 'created_at', 'admin_created_id', 'date_of_employment', 'photo']));
        $array = explode('.',$request->date_of_employment);
        $empl->date_of_employment = date('Y-m-d',strtotime($array[1].'/'.$array[0].'/'.$array[2]));
        if ($request->id_head == -1)
            $empl->id_head = null;

        $empl->save();
        if ($request->hasFile('photo')) {
            (new ImageController)->uploadImage($request, $empl);
        }
        return redirect()->route("employees");
              
    }
}
