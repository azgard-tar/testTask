<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\employee;
use App\Models\position;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function show()
    {
        $data = DB::table('employees')
            ->join('positions', 'employees.id_position', '=', 'positions.id')
            ->select('employees.*', 'positions.title')->get();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->date_of_employment = date(config('app.date_format'), strtotime($data[$i]->date_of_employment));
        }
        return ["employees" => $data, "code" => 200];
    }
    public function getOne($id)
    {
        $empl = employee::find($id);
        if (!is_null($empl)) {
            $empl->date_of_employment = date(config('app.date_format'), strtotime($empl->date_of_employment));
            return ['status' => true, 'employee' => $empl, "code" => 200];
        } else
            return (object)[
                'status' => false,
                "errors" => ["employee" => "Employee was not found"],
                "code" => 404
            ];
    }
    public function delete($id)
    {
        $empl = employee::find($id);
        if (!is_null($empl)) {
            $empl->delete();
            employee::where('id_head', $empl->id)->update(['id_head' => null]);
            return ["error" => null, "code" => 203];
        } else {
            return ["error" => "Employee was not found", "code" => 404];
        }
    }

    public function getAddData()
    {
        $employees = employee::select(['id', 'full_name'])->get();
        $positions = position::select(['id', 'title'])->get();
        return ["employees" => $employees, "positions" => $positions];
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "full_name" => "required|min:2|max:256",
            "date_of_employment" => "required|date",
            "phone_number" => "required|regex:/\+380\(\d{2}\)\d{7}/",
            "email" => "required|email",
            "salary" => "required|min:0|max:500000",
            "id_head" => "required|integer",
            "id_position" => "required|exists:positions,id"
        ]);
        if ($validator->fails()) {
            return (object)['status' => false, 'errors' => $validator->errors()->toArray()];
        }

        $levelOfSubord = $this->checkSubordTree($request->id_head)['level'];
        if( $levelOfSubord == 5 )
            return (object)['status' => false, 'errors' => ["Level of subordination is already 5."]];

        $data = $request->except(['id', 'photo']);
        $data['created_at'] = date(config('app.date_format'));
        $data['updated_at'] = date(config('app.date_format'));
        $data['admin_created_id'] = auth()->user()->id;
        $data['admin_updated_id'] = auth()->user()->id;
        if ($request->id_head == -1)
            $data['id_head'] = null;
        $employee = employee::create($data);
        $employee->save();
        if ($request->photo) {
            (new ImageController)->uploadImage($request, $employee);
        }
        return (object)['status' => true];
    }

    public function checkSubordTree($id)
    {
        $empl['data'] = employee::where('id',$id)->select('id','full_name','id_head')->get();
        $data = employee::where('id_head',$id)->select('id','full_name','id_head')->get();
        $level = 0;
        if( count($data) > 0 ){
            for( $i = 0; $i < count($data); $i++ ){
                $empl['subords'][$i] = $this->checkSubordTree($data[$i]->id);
                if( $empl['subords'][$i]['level'] > $level )
                    $level = $empl['subords'][$i]['level'];
            }
        }
        $empl['level'] = ++$level;
        return $empl;
    }

    public function subord($id){
        return json_encode($this->checkSubordTree($id),true);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "full_name" => "required|min:2|max:256",
            "phone_number" => "required|regex:/\+380\(\d{2}\)\d{7}/",
            "email" => "required|email",
            "salary" => "required|min:0|max:500000",
            "id_head" => "required|integer",
            "id_position" => "required|exists:positions,id"
        ]);
        if ($validator->fails()) {
            return (object)[
                'status' => false,
                'errors' => $validator->errors()->toArray(),
                "code" => 400
            ];
        }


        $levelOfSubord = $this->checkSubordTree($request->id_head)['level'];
        if( $levelOfSubord == 5 )
            return (object)['status' => false, 'errors' => ["Level of subordination is already 5."]];
        if( $levelOfSubord <= $this->checkSubordTree($id)['level'] )
            return (object)['status' => false, 'errors' => ["Level of subordination of this person( 'head' ) is too small."]];


        $empl = employee::find($id);
        if (!is_null($empl)) {
            $request->updated_at = date(config('app.date_format'));
            $request->admin_updated_id = auth()->user()->id;
            $empl->update($request->except(['id', 'created_at', 'admin_created_id', 'date_of_employment', 'photo']));
            if ($request->id_head == -1)
                $empl->id_head = null;
            $empl->date_of_employment = date(config('app.date_format'), strtotime($request->date_of_employment));
            $empl->save();
            if ($request->hasFile('photo')) {
                (new ImageController)->uploadImage($request, $empl);
            }
            return (object)[
                'status' => true,
                "code" => 200
            ];
        } else
            return (object)[
                'status' => false,
                "errors" => "Employee was not found",
                "code" => 404
            ];
    }
}
