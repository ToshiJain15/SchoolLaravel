<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Occupation;

use Illuminate\Support\Facades\Validator;

class OccupationController extends Controller
{
    
    public function nav(){
        return view('nav_head');
    }

    public function show(){
        // $count=Occupation::select(Occupation::raw("occupations.id", "occupations.name", "count(students.id)"))->leftJoin('students', 'students.occupation','=','occupations.id')->groupBy('occupations.id')->get();
        // $data['occupation'] = Occupation::select(["occupations.id","occupations.name",\DB::raw("count(students.id) as count")])
        // ->leftjoin('students', 'students.class_id', '=', 'occupations.id')
        // ->groupBy("occupations.id")
        // ->get();
        $data['data'] = new Occupation();
        return view('occupation',$data);

        //SELECT occupations.id, occupations.name, count(students.id) as count FROM occupations
// left join students on students.occupation=occupations.id
// group by occupations.id
    }

    public function showAjax(){
        $occupations = Occupation::get();
            
            $rec=[];
            foreach($occupations as $key => $val){
                 $rec[]=[
                 $val['id'],
                 $val['name'],
                 0, 

                 "<a href='#' id='".$val->id."' class='edit btn btn-primary'  data-id='".$val->id."'>Edit</a>
    
                 <a href='#'  id='".$val->id."' class='delete btn btn-primary' data-toggle='modal' data-target='#confirmModal' data-id='".$val->id."'>Delete</a>"
                ];
            }

            return response()->json([
                'data' => $rec]);
    }

    public function save(Request $request){
       
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        if(!empty($_POST['name']) && !empty($_POST['id'])){
            $data = Occupation::find($request->id);
            $data->name =$request->name;
            $data->save();
            // return redirect('/occupation');
            return response()->json(['data' => $data]);
        }

        $data = new Occupation();

        $data->name =$request->name;
        $data->save();
        // return redirect('/occupation');
        return response()->json(['data' => $data]);
        
    }

    public function delete(Request $request){
        $data = Occupation::find($request->id);
        $data->delete();
        // return redirect('/occupation');
        return response()->json(['data' => $data]);
    }

    public function editData(Request $request){
        $data['data'] = Occupation::find($request->id);
        $data['occupation'] = Occupation::get();
        // return view('occupationadd',$data);
        return response()->json(['data' => $data]);
    }

    public function update(Request $request){
        $data = Occupation::find($request->id);
        $data->name =$request->name;
        $data->save();
        return response()->json(['data' => $data]);
    }

    public function render(){
        $data['data'] = new Occupation();
        return view('occupationadd',$data);
    }
}