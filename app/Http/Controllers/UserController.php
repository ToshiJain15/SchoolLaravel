<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function index()
    {
        return view('sample');
    }

    // public function add(){

    //     return view('user_form');
    // }

    public function save(Request $request){
        // echo "<pre>";print_r($request->all());exit;
               
        if(!empty($_POST['first_name']) && !empty($_POST['id'])){
            $data = User::find($request->id);
            $data->first_name =$request->first_name;
            $data->last_name =$request->last_name;
            $data->email =$request->email;
            $data->password=$request->password;
            $data->save();
            return redirect('/view');
        }

        $objUser = new User();

        // // $objUSer = $request->all();
        $objUser->first_name =$request->first_name;
        $objUser->last_name =$request->last_name;
        $objUser->email =$request->email;
        $objUser->password =$request->password;
        $objUser->save();
        return redirect('/view');
        
    }
            // $data=$objUser->where('id',$objUser);
        // dd($data);

    public function delete(Request $request){
        $objUser = User::find($request->id);
        $objUser->delete();
        return redirect('/view');
    }

    public function edit(Request $request){
        $data['data'] = User::find($request->id);
        $data['user'] = User::get();
        return view('user_form',$data);
    }


    public function view(){
        $data['user'] = User::get();
        $data['data'] = new user();
        return view('user_form',$data);
    }
}