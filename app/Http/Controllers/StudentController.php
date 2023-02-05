<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function nav(){
        return view('nav_head');
    }

    public function showList(){
        $data['data'] = new Student();
        return view('student_list',$data);
    }
    public function showAjax(){
        //  $data['student'] = $student = Student::select('name','address','email','gender','hobbies','class_id','occupation','languages','photo')->get();
         $data['student'] = $student = Student::get();
        
        // $data=[
        //     [
        //         "admin","chb","fhb@s.c","Male",["Cricket, Bowling"],"1","1",["Hindi, French, Bengali, Malayalam, Marathi, Tamil"],"arrowdn.png"
        //     ],    
        //  ];
        
        $record=[];
        foreach($student as $key => $val){
             $record[]=[
             $val['name'],
             $val['address'],
             $val['email'],
             $val['dob'],
             $val['gender'],
             $val['hobbies'],
             $val['class_id'],
             $val['occupation'],
             $val['languages'],
             $val['photo'],
              
             "<a href='#' id='$val->id' class='edit btn btn-primary'  data-id='{{ $val->id }}'>Edit</a>
    
             <a href='#' id='$val->id' class='delete btn btn-primary' data-id='{{ $val->id }}'>Delete</a>"
             ];
            // "<a href='student/edit/$val->id'>Edit</a>
//  <a href='#'  id='$val->id' class='delete btn btn-primary' data-toggle='modal' data-target='#confirmModal' data-id='{{ $val->id }}'>Delete</a>"
            // <a href='student/delete/$val->id'>Delete</a>"
            // ];
        
        }
         
        return response()->json([
            'data' => $record]);
    }

    public function save(Request $request){

        // $validator = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'address' => 'required',
        //     'email' => 'required',
        //     'gender' => 'required',
        //     'hobbies' => 'required|min:1',
        //     'class_id' => 'required',
        //     'occupation' => 'required',
        //     'language' => 'required',
        //     // 'photo'=>'required|mimes: jpg, jpeg, bmp, png',

        // ]);

        // if ($validator->fails()) {
        //     return redirect()->back()
        //                 ->withErrors($validator)
        //                 ->withInput();
        // }

        // if(!empty($_POST['name']) && !empty($_POST['id'])){
        //     $data = Student::find($request->id);
        //     $data->name = $request->name;
        //     $data->address =$request->address;
        //     $data->email =$request->email;
        //     $data->dob =$request->dob;
        //     $data->gender =$request->gender;
        //     $data->hobbies =implode(', ', $request->hobbies);
        //     $data->class_id =$request->class_id;
        //     $data->occupation =$request->occupation;
        //     $data->languages =implode(', ', $request->languages);
        //     $data->photo =$request->photo;
        //     $data->save();
        //     return response()->json(['data' => $data]);
        // }

        $data = new Student();

        $data->name =$request->name;
        $data->address =$request->address;
        $data->email =$request->email;
        $data->dob =$request->dob;
        $data->gender =$request->gender;
        $data->hobbies =implode(', ',$request->hobbies);
        $data->class_id =$request->class_id;
        $data->occupation =$request->occupation;
        $data->languages =implode(', ', $request->languages);
        // $data->photo =$request->photo;
        $data->save();
        
        return response()->json(['data' => $data]);
        
    }



    public function delete(Request $request){
        $data = Student::find($request->id);
        $data->delete();
        // return redirect('/student');
        return response()->json(['data' => $data]);
    }

    public function editData(Request $request){
        $data['data'] = Student::find($request->id);
        $data['student'] = Student::get();
        // return view('student_add',$data);
        return response()->json(['data' => $data]);
    }

    public function update(Request $request){
        $data = Student::find($request->id);
        $data->name = $request->name;
        $data->address =$request->address;
        $data->email =$request->email;
        $data->dob =$request->dob;
        $data->gender =$request->gender;
        $data->hobbies =implode(', ', $request->hobbies);
        $data->class_id =$request->class_id;
        $data->occupation =$request->occupation;
        $data->languages =implode(', ', $request->languages);
        $data->photo =$request->photo;
        $data->save();
        return response()->json(['data' => $data]);
    }

    public function render(){
        $data['data'] = new Student();
        return view('student_add',$data);
    }
}
