<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClassList;
use App\Http\Controllers\OccupationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\SubController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\LoginController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     echo "I am here";
//     // return view('welcome');
//     return view('sample');
// });

//  Route::get('/',[UserController::class,'index']);
//  Route::get('/add',[UserController::class,'add']);
//  Route::post('/save',[UserController::class,'save']);
//  Route::get('/delete/{id}',[UserController::class,'delete']);
//  Route::get('edit/{id}',[UserController::class,'edit']);
//  Route::get('/view',[UserController::class,'view']);
//  Route::get('/update',[UserController::class,'update']);

 Route::get('/list',[ClassList::class,'view']);
 Route::get('/list/ajax',[ClassList::class,'viewAjax']);
 Route::get('class/edit/{id}',[ClassList::class,'edit']);
 Route::post('class/update/{id}',[ClassList::class,'update']);
 Route::get('class/delete/{id}',[ClassList::class,'delete']);
 Route::get('class/add',[ClassList::class,'add']);
 Route::post('class/save',[ClassList::class,'save']);
 Route::get('/nav',[ClassList::class,'nav']);

 Route::get('/occupation',[OccupationController::class,'show']);
 Route::get('/occupation/ajax',[OccupationController::class,'showAjax']);
 Route::get('occupation/edit/{id}',[OccupationController::class,'editData']);
 Route::post('occupation/update/{id}',[OccupationController::class,'update']);
 Route::get('occupation/delete/{id}',[OccupationController::class,'delete']);
 Route::get('occupation/render',[OccupationController::class,'render']);
 Route::post('occupation/save',[OccupationController::class,'save']);
 Route::get('/nav',[OccupationController::class,'nav']);
 
 Route::get('/student',[StudentController::class,'showList']);
 Route::get('/student/ajax',[StudentController::class,'showAjax']);
 Route::get('student/edit/{id}',[StudentController::class,'editData']);
 Route::post('student/update/{id}',[StudentController::class,'update']);
 Route::get('student/delete/{id}',[StudentController::class,'delete']);
 Route::get('student/render',[StudentController::class,'render']);
 Route::post('student/save',[StudentController::class,'save']);
 Route::get('/nav',[StudentController::class,'nav']);

 Route::get('/city',[CityController::class,'showCity']);
 Route::get('/city/ajax',[CityController::class,'showAjax']);
 Route::post('city/save',[CityController::class,'save']);
 Route::get('/nav',[CityController::class,'nav']);
 Route::get('city/edit/{id}',[CityController::class,'editData']);
 Route::post('city/update/{id}',[CityController::class,'update']);
 Route::get('city/delete/{id}',[CityController::class,'delete']);

 Route::get('/subject',[SubController::class,'showSub']);
 Route::get('/sub/ajax',[SubController::class,'showAjax']);
 Route::post('sub/save',[SubController::class,'save']);
 Route::get('/nav',[SubController::class,'nav']);
 Route::get('sub/edit/{id}',[SubController::class,'editData']);
 Route::post('sub/update/{id}',[SubController::class,'update']);
 Route::get('sub/delete/{id}',[SubController::class,'delete']);

 Route::get('/exam',[ExamController::class,'showExam']);
 Route::get('/exam_list',[ExamController::class,'showList']);
 Route::get('/exam/ajax',[ExamController::class,'showAjax']);
 Route::get('/exam/student/ajax',[ExamController::class,'showAjax1']);
 Route::get('/exam/list/ajax',[ExamController::class,'showlistAjax']);
//  Route::get('/exam/addstudent/{class_id}',[ExamController::class,'showStudent']);
 Route::get('/exam/addstudent/{exam_id}',[ExamController::class,'showStudent']);
 Route::get('/exam/student/{exam_id}',[ExamController::class,'showStudentList']);
 Route::post('/exam/save/student',[ExamController::class,'saveStudent']);
 Route::get('/exam_student/ajax',[ExamController::class,'showstudentAjax']);
 Route::get('/exam/change',[ExamController::class,'showClass']);
 Route::post('exam/save',[ExamController::class,'save']);
 Route::get('/nav',[ExamController::class,'nav']);
 Route::get('exam/edit/{id}',[ExamController::class,'editData']);
 Route::post('exam/update/{id}',[ExamController::class,'update']);
 Route::post('exam/student/update/{id}',[ExamController::class,'updateStudent']);
 Route::get('exam/delete/{id}',[ExamController::class,'delete']);
 Route::get('exam/student/delete/{id}',[ExamController::class,'deleteStudent']);
 Route::get('exam/student/{exam_id}/edit/{id}',[ExamController::class,'editStudent']);
 Route::get('/chart_list',[ExamController::class,'showChartList']);
 Route::get('/chart/data',[ExamController::class,'showChart']);

 Route::get('/user_list',[LogController::class,'showUserList']);
 Route::get('/login/ajax',[LogController::class,'showAjax']);
 Route::post('login/save',[LogController::class,'save']);
 Route::get('login/edit/{id}',[LogController::class,'editData']);
 Route::post('login/update/{id}',[LogController::class,'update']);
 Route::get('login/delete/{id}',[LogController::class,'delete']);

//  Route::get('/dashboard',[LoginController::class,'nav']);
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('nav_head');
})->name('nav_head');

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
