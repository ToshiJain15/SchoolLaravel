<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;

use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    
    public function nav(){
        return view('nav_head');
    }

    public function showCity(){

        $data['data'] = new City();
        return view('city',$data);

    }

    public function showAjax(){
        // $data['city'] = $count =city::select(["city.id","city.name",\DB::raw("count(students.id) as count")])
        // ->leftjoin('students', 'students.city', '=', 'city.id')
        // ->groupBy("city.id")
        // ->get();
        $city =City::select(["cities.id","cities.name",\DB::raw("count(students.id) as count")])
        ->leftjoin('students', 'students.class_id', '=', 'cities.id')
        ->groupBy("cities.id")
        ->get();

        // $data['city'] = $city = city::get();
            
            $rec=[];
            foreach($city as $key => $val){
                 $rec[]=[
                 $val['id'],
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
            $data = City::find($request->id);
            $data->name =$request->name;
            $data->save();
            return response()->json(['data'=>$data]);
        }

        $data = new City();

        $data->name =$request->name;
        $data->save();
        return response()->json(['data'=>$data]);
        
    }

    public function delete(Request $request){
        $data = City::find($request->id);
        $data->delete();
        return response()->json(['data' => $data]);
    }

    public function editData(Request $request){
        $data['data'] = City::find($request->id);
        return response()->json(['data' => $data]);
    }

    public function update(Request $request){
        $data = City::find($request->id);
        $data->name =$request->name;
        $data->save();
        return response()->json(['data' => $data]);
    }
}