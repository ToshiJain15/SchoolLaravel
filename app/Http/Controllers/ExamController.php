<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\ExamSubject;
use App\Models\ExamStudent;
use App\Models\Subject;

use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    
    public function nav(){
        return view('nav_head');
    }

    public function showChartList(){

        return view('chart');

    }

    public function showExam(){

        $data['data'] = new Exam();
        $data['data'] = new ExamSubject();
        return view('exam',$data);

    }
 
    public function showList(Request $request){
        $data['data'] = new Exam();
        return view('exam_list',$data);
    }

    public function showStudent(Request $request){
        $data['exam_id'] = Exam::find($request->exam_id);
        // $data['class_id'] = Exam::find($request->class_id);
        $data['data'] = new ExamStudent();
        return view('exam_student',$data);
    }

    public function showStudentList(Request $request){
        $data['exam_id'] = Exam::find($request->exam_id);
        // $data['class_id'] = Exam::select('class_id')->first();
        $data['data'] = new ExamStudent();
        return view('exam_studentlist',$data);
    }

    public function showlistAjax(){
        $exams =Exam::select()
        ->get();
            
            $rec=[];
            foreach($exams as $key => $val){
                 $rec[]=[
                 $val['id'],
                 $val['name'],
      
                //  "<a href='#' id='$val->id' class='edit btn btn-primary'  data-id='{{ $val->id }}' data-target='#examdata'>Edit</a>
    
                //  <a href='#'  id='$val->id' class='delete btn btn-primary' data-toggle='modal' data-target='#confirmModal' data-id='{{ $val->id }}'>Delete</a>"
                //  ];
                "<a href='exam/edit/$val->id' class='edit btn btn-primary'>Edit</a>
                 <a href='exam/addstudent/$val->id' class='btn btn-primary'>Add Student</a>
    
                <a href='exam/delete/$val->id' class='delete btn btn-primary' >Delete</a>
                <a href='exam/student/$val->id' class= 'btn btn-primary' >Student</a>"
                ];
            
            }
           
            return response()->json([
                'data' => $rec]);
    }

    public function showstudentAjax(Request $request){
        // $data['id'] = Exam::find($request->id);
        // $exams =ExamStudent::select(["exam_students.id","students.name","exam_students.marks as marks","exam_subjects.total) as total","exam_students.student_id","exam_students.exam_id as exam_id"])
        $exams =ExamStudent::select(["exam_students.id","students.name",\DB::raw("sum(exam_students.marks) as marks"),\DB::raw("sum(exam_subjects.total) as total"),"exam_students.student_id","exam_students.exam_id as exam_id"])
        // ->leftjoin('exams', 'exam_students.exam_id', '=', 'exams.id')
        ->leftjoin('students', 'exam_students.student_id', '=', 'students.id')
        ->leftjoin('exam_subjects','exam_students.subject_id', '=', 'exam_subjects.subject_id' )
        ->where('exam_students.exam_id', '=', $request->exam_id)
        ->groupBy("exam_students.student_id")
        ->get();
        // $exams =ExamStudent::select()
        // ->get();
        // $data = Exam::find($request->exam_id);
        // $max = ExamSubject::where([['exam_id','=',$request->exam_id],['subject_id','=',' 1']])->value('total');     
            $rec=[];
            foreach($exams as $key => $val){
                if($val['marks']>$val['total']){
                   $a = "pass";
                }else{
                   $a ='fail';
                }
                 $rec[]=[
                 $val['id'],
                 $val['name'],
                 $val['marks'],
                //  $val['total'],
                 $a,
                 
                //  "<a href='#' id='$val->id' class='edit btn btn-primary'  data-id='{{ $val->id }}' data-target='#examdata'>Edit</a>
    
                //  <a href='#'  id='$val->id' class='delete btn btn-primary' data-toggle='modal' data-target='#confirmModal' data-id='{{ $val->id }}'>Delete</a>"
                //  ];
                "<a href='$val->exam_id/edit/$val->id' class='edstudent btn btn-primary'>Edit</a>
                 <a href='delete/$val->id' class='delete btn btn-primary' >Delete</a>"
                ];
            
            }
           
            return response()->json([
                'data' => $rec]);
    }

    public function showAjax(Request $request){
 
        $exam =Subject::select("subjects.id","subjects.name")
        ->join('exam_subjects','exam_subjects.subject_id','=',"subjects.id")
        ->where('class_id','=',$request->class_id)
        ->get();
        // if(ExamSubject::where('exam_subjects.subject_id','=','subjects.id')->exists()){
            // if(ExamSubject::has('subjects.id')){
        // $exam =$exam->ExamSubject::addselect("exam_subjects.subject_id","exam_subjects.max_marks","exam_subjects.total")
        // ->where('exam_id','=',$request->exam_id)
        // ->get();}
        $exams =ExamSubject::select("exam_subjects.subject_id","exam_subjects.max_marks","exam_subjects.total")
        ->where('exam_id','=',$request->exam_id)
        ->get();
            
            $rec=[];
            foreach($exam as $key => $val){
                 $rec[]=[
                    //  "<input type='checkbox' />",
                 $val['id'],
                 $val['name'],
                ];
            
            }
            foreach($exams as $key => $val){
                 $recs[]=[
                  $val['subject_id'], 
                  $val['max_marks'], 
                  $val['total'], 
                ];
            
            }
            
            // return response()->json([
            //     'data' => $exam]);

            if($request->exam_id){
            return response()->json([
                'data' => $rec,'subject'=> $recs]);
            }else{
            return response()->json([
                'data' => $rec,]);
            }
    }
    public function showAjax1(Request $request){
        $exams =ExamSubject::select("exam_subjects.subject_id as id","subjects.name as name","exam_subjects.max_marks as max","exam_subjects.total as pass")
        ->join('subjects','subjects.id','=','exam_subjects.subject_id')
        ->leftjoin('exam_students','exam_students.subject_id','=','exam_subjects.subject_id')
        ->where('exam_subjects.exam_id','=',$request->exam_id);
        // ->where('exam_students.student_id','=',$request->student_id);
        if(ExamStudent::where('exam_students.student_id','=',$request->student_id)->exists()){
            $exams=$exams->addSelect(ExamSubject::raw("exam_students.student_id as student_id"))
            ->addSelect(ExamSubject::raw("exam_students.marks as marks"))
            // ->leftjoin('exam_students','exam_students.subject_id','=','exam_subjects.subject_id')
            ->where('exam_students.student_id','=',$request->student_id);
            // ->get();
        }
        // else{
            $exams=$exams->get();
           
        // }
        
           
            return response()->json([
                'data' => $exams]);
            
    }

    public function showChart(Request $request){

        $exams =Exam::select(["exams.id","exams.name","exam_subjects.total","exam_students.student_id"])
        ->join('exam_students','exam_id','=','exams.id')
        ->join('exam_subjects', function($join)
        {
            $join->on('exams.id', '=', 'exam_subjects.exam_id');
            $join->on('exam_students.subject_id', '=', 'exam_subjects.subject_id');
        })
        ->where('class_id','=',$request->class_id)
        ->get();

        $exam =ExamStudent::select(["exam_students.id",\DB::raw("sum(exam_students.marks) as marks"),\DB::raw("(sum(exam_students.marks)/sum(exam_subjects.max_marks) * 100) as per"),"exam_students.student_id","exam_students.exam_id as exam_id"])
        ->join('exam_subjects','exam_subjects.subject_id','=',"exam_students.subject_id")
        ->leftjoin('exams', 'exam_students.exam_id', '=', 'exams.id')
        ->leftjoin('students', 'exam_students.student_id', '=', 'students.id')
        ->where('students.class_id','=',$request->class_id)
        ->groupBy("exam_students.student_id");
        // if("per">45){ 
        //   $exam = $exam->addselect(\DB::raw("(count(DISTINCT exam_students.`student_id`)) as pass"));
        // }
        if("per"<45){
          $exam = $exam->addselect(\DB::raw("(count(DISTINCT exam_students.`student_id`)) as fail"));
        }
        
        $exam=$exam->get();
        // $recs=ExamStudent::select(["exam_students.id","exams.name",\DB::raw('SUM(DISTINCT IF(((SUM(exam_students.marks)/SUM(exam_subjects.max_marks) * 100) > 45),exam_students.`student_id`,null)) as pass'),\DB::raw('SUM(DISTINCT IF(((SUM(exam_students.marks)/SUM(exam_subjects.max_marks) * 100) < 45),exam_students.`student_id`,null)) as fail')])
        // ->leftjoin('exams', 'exam_students.exam_id', '=', 'exams.id')
        // ->leftjoin('students', 'exam_students.student_id', '=', 'students.id')
        // ->leftjoin('exam_subjects','exam_students.subject_id', '=', 'exam_subjects.subject_id' )
        // ->where('students.class_id','=',$request->class_id)
        // ->groupBy("exam_students.exam_id")
        // ->get();
        // select sum(exam_students.marks) as marks, sum(exam_subjects.total) as total, sum(exam_subjects.max_marks) as max, (sum(exam_students.marks)/sum(exam_subjects.max_marks) * 100) as per from `exam_students` join `exam_subjects` on `exam_students`.`subject_id` = `exam_subjects`.`subject_id` group by `student_id`,`exam_subjects`.`exam_id`
            return response()->json([
                'data' => $exams]);
            
    }
   
    public function save(Request $request){
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'class_id' => 'required',
            // 'subject_id' => 'required'
        ]); 

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        // if(!empty($_POST['name']) && !empty($_POST['id'])){
        //     $data = Exam::find($request->id);
        //     $data->name =$request->name;
        //     $data->save();
        //     return response()->json(['data'=>$data]);
        // }

        $data = new Exam();

        $data->name =$request->name;
        $data->class_id =$request->class_id;
        $data->save();
         $id=Exam::select()->where([['name','=',$request->name],['class_id','=',$request->class_id]])->get();
 
        foreach($request->input('subject_id') as $key => $value) {

            $data = new ExamSubject();
            $data->exam_id = $id[0]['id'];

            $data->subject_id =$request->get('subject_id')[$key];
            $data->max_marks =$request->get('max_marks')[$key];
            $data->total =$request->get('pass_marks')[$key];
            $data->save();
        }
        // $finalArray = array();
        // foreach($data as $key=>$value){
        //  array_push($finalArray, array(
        //         'subject_id'=>$value['subject_id'],
        //         'max_marks'=>$value['max_marks'],
        //         'total'=>$value['total'])
        //  );
        // };

        // ExamSubject::insert($finalArray);
        // foreach($request->subject_id as $key =>$subject_id){
        //     $data = array(
        //                     'subject_id'=>$request->subject_id[$key],
        //                     'max_marks'=>$request->max_marks [$key],
        //                     'total'=>$request->total [$key],
        //         );
        //     }
        // $data->subject_id =$request->subject_id;
        // $data->max_marks =$request->max_marks;
        // $data->total =$request->pass_marks;
        $data->save();

        return response()->json(['data'=>$data]);
        
    }
  
    public function saveStudent(Request $request){
        
        $validator = Validator::make($request->all(), [
            'student_id' => 'required',
            // 'subject_id' => 'required'
        ]); 

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        // if(!empty($_POST['name']) && !empty($_POST['id'])){
        //     $data = Exam::find($request->id);
        //     $data->name =$request->name;
        //     $data->save();
        //     return response()->json(['data'=>$data]);
        // }

        $id=Exam::select()->where([['name','=',$request->name],['class_id','=',$request->class_id]])->get();

        foreach($request->input('subject_id') as $key => $value) {
            $data = new ExamStudent();
            $data->exam_id =$request->get('exam_id');
            $data->subject_id =$request->get('subject_id')[$key];
            $data->student_id =$request->get('student_id');
            $data->marks =$request->get('marks')[$key];
            $data->save();
        }


        return response()->json(['data'=>$data]);
        
    }

    public function delete(Request $request){
        $data = Exam::find($request->id);
        $data->delete();
        // $id=Exam::select()->where([['name','=',$request->name],['class_id','=',$request->class_id]])->get();
        $data = ExamSubject::select()->where('exam_id','=',$request->id);
        $data->delete();
        // return response()->json(['data'=>$data]);
        return redirect('/exam_list');
    }

    public function deleteStudent(Request $request){
        $data = ExamStudent::find($request->id);
        $data->delete();
        // return response()->json(['data'=>$data]);
        return redirect('/exam_list');
    }

    public function editData(Request $request){
        $data['data'] = Exam::find($request->id);
        // $data['exam'] = Exam::get();
        $data['subject'] = ExamSubject::find($request->id);   
        // return response()->json(['data' => $data]);
        return view('exam',$data);
        // return response()->view('exam', $data);
    }

    public function editStudent(Request $request){

        $data['data'] = ExamStudent::find($request->id); 
        $data['exam_id'] = Exam::find($request->exam_id);
        $data['student_id'] = Exam::find($request->student_id);
          
        // return response()->json(['data' => $data]);
        return view('exam_student',$data);
        // return response()->view('exam', $data);
    }

    public function update(Request $request){
        $data = Exam::find($request->id);

        $data->name =$request->name;
        // $data->class_id =$request->class_id;
        $data->save();
         $id=Exam::select()->where([['name','=',$request->name],['class_id','=',$request->class_id]])->get();
        //  $data = ExamSubject::find($request->id);
         foreach($request->input('subject_id') as $key => $value) {
            // $request->get('subject_id')[$key];
            $data = ExamSubject::where('subject_id','=',$request->get('subject_id')[$key])
            ->update(['max_marks' => $request->get('max_marks')[$key],'total' => $request->get('pass_marks')[$key]]);
        }
        //  $data = ExamSubject::find('id')->where('exam_id','=',$request->id);
        // $data->exam_id = $id[0]['id'];
        // foreach($request->input('subject_id') as $key => $value) {
        //     $data->max_marks =$request->get('max_marks')[$key];
        //     $data->total =$request->get('pass_marks')[$key];
        //     $data->save();
        // }

        return response()->json(['data' => $data]);
    }

    public function updateStudent(Request $request){
        
        // $data->subject_id =$request->subject_id;
        // $data->student_id =$request->student_id;
        // $data = ExamStudent::find($request->id);
        foreach($request->input('marks') as $key => $value) {
            // $request->get('subject_id')[$key];
            $data = ExamStudent::where('subject_id','=',$request->get('subject_id')[$key])->where('student_id','=',$request->student_id)->where('exam_id','=',$request->exam_id)
            ->update(['marks' => $request->get('marks')[$key]]);
            // $data->marks =$request->get('marks')[$key];
            // $data->save();
        }


        return response()->json(['data' => $data]);
    }
}