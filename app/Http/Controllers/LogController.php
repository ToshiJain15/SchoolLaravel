<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class LogController extends Controller
{

    protected function authenticated(Request $request, $user)
    {
        return response([
            // 'data'=>$data;
        ]);
    }

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
            $data = User::find($request->id);
            $data->name =$request->name;
            $data->save();
            return response()->json(['data'=>$data]);
        }

        $data = new User();

        $data->name =$request->name;
        $data->save();
        return response()->json(['data'=>$data]);
        
    }
    //         // $data=$objUser->where('id',$objUser);
    //     // dd($data);

    public function delete(Request $request){
        $data = User::find($request->id);
        $data->delete();
        // return redirect('/list');
        return response()->json(['data'=>$data]);
    }

    public function edit(Request $request){
        $data['data'] = User::find($request->id);
        $data['class'] = User::get();
        // return view('add_form',$data);
        return response()->json(['data'=>$data]);
    }


    public function showUserList(){
        // $data['class'] = User::select(["User.id","User.name",\DB::raw("count(students.id) as count")])
        // ->leftjoin('students', 'students.class_id', '=', 'User.id')
        // ->groupBy("User.id")
        // ->get();
        $data['data'] = new User();
        return view('user_list');
    }
    // SELECT User.id, User.name, count(students.id) as count FROM User left join students on students.class_name=User.id group by User.id
    
    public function showAjax(){
        $users = User::get();
            
            $rec=[];
            foreach($users as $key => $val){
                 $rec[]=[
                 $val->id,
                 $val->name,
                 $val->email,
      
                 "<a href='#' id='".$val->id."' class='edit btn btn-primary' data-id='".$val->id."'>Edit</a>
    
                 <a href='#' id='".$val->id."' class='delete btn btn-primary' data-id='".$val->id."'>Delete</a>"
                 ];
            }
           
            return response()->json([
                'data' => $rec]);
    }
    
    public function update(Request $request){
        $data = User::find($request->id);
        $data->name =$request->name;
        $data->save();
        return response()->json(['data' => $data]);
    }

    public function add(){
        $data['data'] = new User();
        return view('add_form',$data);
    }
}