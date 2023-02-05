<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classes;
use Illuminate\Support\Facades\Validator;

class ClassList extends Controller
{

    public function nav(){
        return view('nav_head');
    }


    public function save(Request $request){
        // echo "<pre>";print_r($request->all());exit;
        
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
               
        if(!empty($_POST['name']) && !empty($_POST['id'])){
            $data = Classes::find($request->id);
            $data->name =$request->name;
            $data->save();
            return response()->json(['data'=>$data]);
        }

        $data = new Classes();

        $data->name =$request->name;
        $data->save();
        return response()->json(['data'=>$data]);
        
    }
    //         // $data=$objUser->where('id',$objUser);
    //     // dd($data);

    public function delete(Request $request){
        $data = Classes::find($request->id);
        $data->delete();
        // return redirect('/list');
        return response()->json(['data'=>$data]);
    }

    public function edit(Request $request){
        $data['data'] = Classes::find($request->id);
        $data['class'] = Classes::get();
        // return view('add_form',$data);
        return response()->json(['data'=>$data]);
    }


    public function view(){
        // $data['class'] = Classes::select(["classes.id","classes.name",\DB::raw("count(students.id) as count")])
        // ->leftjoin('students', 'students.class_id', '=', 'classes.id')
        // ->groupBy("classes.id")
        // ->get();
        $data['data'] = new Classes();
        return view('class_list');
    }
    // SELECT classes.id, classes.name, count(students.id) as count FROM classes left join students on students.class_name=classes.id group by classes.id
    
    public function viewAjax(){
        $classes =Classes::select(["classes.id","classes.name",\DB::raw("count(students.id) as count")])
        ->leftjoin('students', 'students.class_id', '=', 'classes.id')
        ->groupBy("classes.id")
        ->get();
            
            $rec=[];
            foreach($classes as $key => $val){
                 $rec[]=[
                 $val['id'],
                 $val['name'],
                 $val['count'],
      
                 "<a href='#' id='$val->id' class='edit btn btn-primary'  data-id='{{ $val->id }}'>Edit</a>
    
                 <a href='#'  id='$val->id' class='delete btn btn-primary' data-toggle='modal' data-target='#confirmModal' data-id='{{ $val->id }}'>Delete</a>"
                 ];
                // "<a href='class/edit/$val->id'>Edit</a>
    
                // <a href='class/delete/$val->id'>Delete</a>"
                // ];
            
            }
           
            return response()->json([
                'data' => $rec]);
    }
    
    public function update(Request $request){
        $data = Classes::find($request->id);
        $data->name =$request->name;
        $data->save();
        return response()->json(['data' => $data]);
    }

    public function add(){
        $data['data'] = new Classes();
        return view('add_form',$data);
    }
}