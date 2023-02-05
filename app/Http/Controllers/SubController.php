<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;

use Illuminate\Support\Facades\Validator;

class SubController extends Controller
{
    
    public function nav(){
        return view('nav_head');
    }

    public function showSub(){

        $data['data'] = new Subject();
        return view('subject',$data);

    }

    public function showAjax(){
        // $data['Subject'] = $count =subject::select(["subject.id","subject.name",\DB::raw("count(students.id) as count")])
        // ->leftjoin('students', 'students.subject', '=', 'subject.id')
        // ->groupBy("subject.id")
        // ->get();
        // $subject =Subject::select(["subjects.id","subjects.name",\DB::raw("count(students.id) as count")])
        // ->leftjoin('students', 'students.class_id', '=', 'subjects.id')
        // ->groupBy("subjects.id")
        // ->get();

        $data['subject'] = $subject = Subject::get();
            
            $rec=[];
            foreach($subject as $key => $val){
                 $rec[]=[
                 $val['id'],
                 $val['class_id'],
                 $val['name'],
                //  $val['count'],
      
                "<a href='#' id='$val->id' class='edit btn btn-primary'  data-id='{{ $val->id }}'>Edit</a>
    
                <a href='#'  id='$val->id' class='delete btn btn-primary' data-toggle='modal' data-target='#confirmModal' data-id='{{ $val->id }}'>Delete</a>"
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
            $data = Subject::find($request->id);
            $data->class_id =$request->class_id;
            $data->name =$request->name;
            $data->save();
            return response()->json(['data'=>$data]);
        }

        $data = new Subject();

        $data->class_id =$request->class_id;
        $data->name =$request->name;
        $data->save();
        return response()->json(['data'=>$data]);
        
    }

    public function delete(Request $request){
        $data = Subject::find($request->id);
        $data->delete();
        return response()->json(['data' => $data]);
    }

    public function editData(Request $request){
        $data['data'] = Subject::find($request->id);
        $data['subject'] = Subject::get();
        return response()->json(['data' => $data]);
    }

    public function update(Request $request){
        $data = Subject::find($request->id);
        $data->class_id =$request->class_id;
        $data->name =$request->name;
        $data->save();
        return response()->json(['data' => $data]);
    }
}