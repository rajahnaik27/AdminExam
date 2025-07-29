<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\ExaminerController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ScannerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::get('get_attendance_history', [ApiController::class, 'get_attendance_history']);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [ApiController::class, 'authenticate']);
Route::post('register', [ApiController::class, 'register']);

//Master Data Management
Route::post('get_examiner_list',[AdminController::class, 'get_examiner_list']);
Route::post('get_examiner',[AdminController::class, 'get_examiner']);
Route::post('add_examiner',[AdminController::class, 'add_examiner']);
Route::post('update_examiner',[AdminController::class, 'update_examiner']);
Route::post('add_student',[AdminController::class, 'add_student']);
Route::post('update_student',[AdminController::class, 'update_student']);

//Institute Management
Route::post('add_institute',[InstituteController::class, 'add_institute']);
Route::post('update_institute',[InstituteController::class, 'update_institute']);
Route::post('get_institute',[InstituteController::class, 'get_institute']);
Route::get('get_institute_list',[InstituteController::class, 'get_institute_list']);
Route::post('delete_role',[InstituteController::class, 'delete_role']);
Route::post('delete_institute',[InstituteController::class, 'delete_institute']);

//For Examiner 
Route::post('class_list',[ExaminerController::class, 'get_class_name_list']);
Route::post('division_list',[ExaminerController::class, 'get_division_name_list']);
Route::post('semester_list',[ExaminerController::class, 'get_semester_name_list']);
Route::post('academic_year_list',[ExaminerController::class, 'get_academic_year_list']);
Route::post('question_paper_list',[ExaminerController::class, 'get_question_paper_list']);
Route::post('answer_paper_list',[ExaminerController::class, 'get_answer_paper_list']);
Route::post('add_exam',[ExaminerController::class, 'create_exam']);
Route::post('exam_details',[ExaminerController::class, 'get_exam_details']);
Route::post('fetch_edit_exam_data',[ExaminerController::class, 'get_edit_exam_data']);
Route::post('update_exam_data',[ExaminerController::class, 'update_exam_details']);
Route::post('delete_exam_data',[ExaminerController::class, 'delete_exam_details']);
Route::post('get_create_exam_id',[ExaminerController::class, 'get_create_exam_id']);
Route::get('get_assigned_examiner_list',[ExaminerController::class, 'get_assigned_examiner_list']);

//For Teacher 
Route::post('question_number_list',[TeacherController::class, 'get_question_number_list']);
Route::post('question_type_list',[TeacherController::class, 'get_question_type_list']);
Route::post('question_part_list',[TeacherController::class, 'get_question_part_list']);
Route::post('question_mark_list',[TeacherController::class, 'get_question_mark_list']);
Route::post('add_subject_question',[TeacherController::class, 'create_subject_question']);
Route::post('get_teacher_create_question_list',[TeacherController::class, 'teacher_create_question_list']);
Route::post('get_teacher_dashboard_list',[TeacherController::class, 'teacher_dashboard_list']);
Route::post('get_answer_sheet_list',[TeacherController::class, 'answer_sheet_list']);
Route::post('update_subject_data',[TeacherController::class, 'update_subject_details']);
Route::post('delete_subject_data',[TeacherController::class, 'delete_subject_details']);
Route::post('fetch_create_question_list_for_edit',[TeacherController::class, 'fetch_create_question_list_for_edit']);
Route::post('question_paper_managment_list',[TeacherController::class, 'question_paper_managment_list']);
Route::post('assign_teacher_to_asheet',[TeacherController::class, 'assign_teacher_to_asheet']);
Route::get('get_assigned_teacher_list',[TeacherController::class, 'get_assigned_teacher_list']);

//For student 
Route::post('fetch_student_profile',[StudentController::class, 'fetch_student_profile']);
Route::post('change_student_password',[StudentController::class, 'reset_student_password']);

//For scanner 
Route::post('add_answer_sheet_data',[ScannerController::class, 'add_answer_sheet']);
Route::post('add_scanner_data',[ScannerController::class, 'add_scanner_profile']);
Route::post('change_scanner_password',[ScannerController::class, 'reset_scanner_password']);
Route::post('get_scanner_dashboard_list',[ScannerController::class, 'scanner_dashboard_list']);
Route::post('send_to_examiner',[ScannerController::class, 'send_to_examiner']);

Route::post('get_answersheet_data_by_id',[TeacherController::class, 'get_answersheet_data_by_id']);

Route::post('get_answer_data_by_id',[TeacherController::class, 'get_answer_data_by_id']);


Route::get('pdf_generate/{id}',[TeacherController::class, 'pdf_generate']);
// Route::get('send_sms', [ApiController::class, 'send_sms']);
// Route::group(['middleware' => ['jwt.verify']], function() {
//     Route::get('logout', [ApiController::class, 'logout']);
//     Route::get('get_user', [ApiController::class, 'get_user']);
// });  