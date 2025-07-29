<?php

namespace App\Http\Controllers;
//use DB;
use Illuminate\Http\Request;
use App\Models\QuestionNumberList;
use App\Models\QuestionTypeList;
use App\Models\QuestionPartList;
use App\Models\QuestionMarkList;
use App\Models\CreateSubject;
use App\Models\CreateSubjectDetails;
use App\Models\AddAnswerSheet;
use App\Models\AssignedSheet;
use App\Models\AssignedTeacher;
use \Mpdf\Mpdf as PDF;


class TeacherController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

    }

    //get question number list
    public function get_question_number_list(Request $request)
    {
        try {
                $QuestionNumberList = QuestionNumberList::select('id','question_number')->orderby('question_number','asc')->get();
				if(count($QuestionNumberList)>0){
					return response()->json([
						'success' => true,
						'data' => $QuestionNumberList
					]);
				}else{
					$QuestionNumberList = [];
					return response()->json([
						'success' => true,
						'data' => $QuestionNumberList
					]);
				}
        }catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Oops! Something Went Wrong,  Please Try Again',
            ], 200);
        }
    }

    //get question number list
    public function get_question_type_list(Request $request)
    {
        try {
                $QuestionTypeList = QuestionTypeList::select('id','question_type')->orderby('question_type','asc')->get();
				if(count($QuestionTypeList)>0){
					return response()->json([
						'success' => true,
						'data' => $QuestionTypeList
					]);
				}else{
					$QuestionTypeList = [];
					return response()->json([
						'success' => true,
						'data' => $QuestionTypeList
					]);
				}
        }catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Oops! Something Went Wrong,  Please Try Again',
            ], 200);
        }
    }

    //get question part list
    public function get_question_part_list(Request $request)
    {
        try {
                $QuestionPartList = QuestionPartList::select('id','question_part')->orderby('question_part','asc')->get();
				if(count($QuestionPartList)>0){
					return response()->json([
						'success' => true,
						'data' => $QuestionPartList
					]);
				}else{
					$QuestionPartList = [];
					return response()->json([
						'success' => true,
						'data' => $QuestionPartList
					]);
				}
        }catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Oops! Something Went Wrong,  Please Try Again',
            ], 200);
        }
    }

    //get question mark list
    public function get_question_mark_list(Request $request)
    {
        try {
                $QuestionMarkList = QuestionMarkList::select('id','question_mark')->orderby('question_mark','asc')->get();
				if(count($QuestionMarkList)>0){
					return response()->json([
						'success' => true,
						'data' => $QuestionMarkList
					]);
				}else{
					$QuestionMarkList = [];
					return response()->json([
						'success' => true,
						'data' => $QuestionMarkList
					]);
				}
        }catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Oops! Something Went Wrong,  Please Try Again',
            ], 200);
        }
    }

    //add subject question data
    /*public function create_subject_question(Request $request){
        try {
                $CreateSubject_id = $request->CreateSubject_id;
                if(!empty($CreateSubject_id)){


                    $List_of_question = $request->question_list;
                    $List_of_questions = json_decode($List_of_question,true);
                    foreach($List_of_questions as $List_of_question){
                        $question_part_id = $List_of_question['question_part_id'];
                        if($question_part_id == 1){
                            foreach($List_of_question['multiple'] as $mcq){
                                $CreateSubjectDetails = new CreateSubjectDetails();
                                $CreateSubjectDetails->question_number_id = $List_of_question['question_number_id'];
                                $CreateSubjectDetails->question_type_id = $List_of_question['question_type_id'];
                                $CreateSubjectDetails->question_part_id = $List_of_question['question_part_id'];
                                $CreateSubjectDetails->question_mark_id = $List_of_question['question_mark_id'];
                                $CreateSubjectDetails->question = $List_of_question['question'];
                                $CreateSubjectDetails->ideal_answer = $mcq['ideal_answer'];
                                $CreateSubjectDetails->ideal_answer_status = $mcq['ideal_answer_status'];
                                $CreateSubjectDetails->create_subject_id = $CreateSubject_id;
                                $CreateSubjectDetails->created_at = date('Y-m-d H:i:s');
                                $CreateSubjectDetails->updated_at = date('Y-m-d H:i:s');
                                $CreateSubjectDetails->save();
                            }


                        }else{
                            $CreateSubjectDetails = new CreateSubjectDetails();
                            $CreateSubjectDetails->question_number_id = $List_of_question['question_number_id'];
                            $CreateSubjectDetails->question_type_id = $List_of_question['question_type_id'];
                            $CreateSubjectDetails->question_part_id = $List_of_question['question_part_id'];
                            $CreateSubjectDetails->question_mark_id = $List_of_question['question_mark_id'];
                            $CreateSubjectDetails->question = $List_of_question['question'];
                            $CreateSubjectDetails->ideal_answer = $List_of_question['ideal_answer'];
                            $CreateSubjectDetails->ideal_answer_status = $List_of_question['ideal_answer_status'];
                            $CreateSubjectDetails->create_subject_id = $CreateSubject_id;
                            $CreateSubjectDetails->created_at = date('Y-m-d H:i:s');
                            $CreateSubjectDetails->updated_at = date('Y-m-d H:i:s');
                            $CreateSubjectDetails->save();
                        }
                    }
                    return response()->json([
                        'success' => true,
                        'data' => 'Subject Question data was generated.'
                    ]);
                }else{
                    $CreateSubject = new CreateSubject();
                    $List_of_question = $request->question_list;
                    $CreateSubject->teacher_id = $request->teacher_id;
                    $CreateSubject->exam_details_id = $request->exam_details_id;
                    $CreateSubject->total_marks = $request->total_marks;
                    $CreateSubject->passed_marks = $request->passed_marks;
                    $CreateSubject->total_questions = $request->total_questions;
                    $CreateSubject->role_id = $request->role_id;
                    $CreateSubject->created_at = date('Y-m-d H:i:s');
                    $CreateSubject->updated_at = date('Y-m-d H:i:s');
                    $CreateSubject->save();
                    $CreateSubject_id = $CreateSubject->id;
                    $List_of_questions = json_decode($List_of_question,true);
                    foreach($List_of_questions as $List_of_question){
                        $question_part_id = $List_of_question['question_part_id'];
                        if($question_part_id == 1){
                            foreach($List_of_question['multiple'] as $mcq){
                                $CreateSubjectDetails = new CreateSubjectDetails();
                                $CreateSubjectDetails->question_number_id = $List_of_question['question_number_id'];
                                $CreateSubjectDetails->question_type_id = $List_of_question['question_type_id'];
                                $CreateSubjectDetails->question_part_id = $List_of_question['question_part_id'];
                                $CreateSubjectDetails->question_mark_id = $List_of_question['question_mark_id'];
                                $CreateSubjectDetails->question = $List_of_question['question'];
                                $CreateSubjectDetails->ideal_answer = $mcq['ideal_answer'];
                                $CreateSubjectDetails->ideal_answer_status = $mcq['ideal_answer_status'];
                                $CreateSubjectDetails->create_subject_id = $CreateSubject_id;
                                $CreateSubjectDetails->created_at = date('Y-m-d H:i:s');
                                $CreateSubjectDetails->updated_at = date('Y-m-d H:i:s');
                                $CreateSubjectDetails->save();
                            }
                        }else{
                            $CreateSubjectDetails = new CreateSubjectDetails();
                            $CreateSubjectDetails->question_number_id = $List_of_question['question_number_id'];
                            $CreateSubjectDetails->question_type_id = $List_of_question['question_type_id'];
                            $CreateSubjectDetails->question_part_id = $List_of_question['question_part_id'];
                            $CreateSubjectDetails->question_mark_id = $List_of_question['question_mark_id'];
                            $CreateSubjectDetails->question = $List_of_question['question'];
                            $CreateSubjectDetails->ideal_answer = $List_of_question['ideal_answer'];
                            $CreateSubjectDetails->ideal_answer_status = $List_of_question['ideal_answer_status'];
                            $CreateSubjectDetails->create_subject_id = $CreateSubject_id;
                            $CreateSubjectDetails->created_at = date('Y-m-d H:i:s');
                            $CreateSubjectDetails->updated_at = date('Y-m-d H:i:s');
                            $CreateSubjectDetails->save();
                        }
                    }
                    return response()->json([
                        'success' => true,
                        'data' => 'Subject Question data was generated.',
                        'exam_details_id'=>$request->exam_details_id,
                        'CreateSubject_id'=>$CreateSubject_id,
                    ]);
                }
        } catch (Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Oops! Something Went Wrong,  Please Try Again',
                ], 200);
        }
    }*/

 public function create_subject_question(Request $request){
        try {

				$exam_details_id = $request->exam_details_id;

				$exam_detail_exist = CreateSubject::select('id')->where('exam_details_id', $exam_details_id)->get();
				$check_exam_id_exist = isset($exam_detail_exist[0]->id)?$exam_detail_exist[0]->id:'';

				if($check_exam_id_exist != ''){
					$CreateSubject_id = $check_exam_id_exist;
				}else{
					$CreateSubject_id = $request->CreateSubject_id;
				}


                if(!empty($CreateSubject_id) ){

					$question_number_id = $request->question_number_id;
					$question_type_id = $request->question_type_id;
					$question_part_id = $request->question_part_id;
					$question_mark_id = $request->question_mark_id;
					$question = $request->question;

					if($question_type_id == 1){


							$CreateSubjectDetails = new CreateSubjectDetails();
                            $CreateSubjectDetails->question_number_id = $request->question_number_id;
                            $CreateSubjectDetails->question_type_id = $request->question_type_id;
                            $CreateSubjectDetails->question_part_id = $request->question_part_id;
                            $CreateSubjectDetails->question_mark_id = $request->question_mark_id;
                            $CreateSubjectDetails->question = $request->question;

                            $CreateSubjectDetails->ideal_ans1 = $request->ideal_ans1;
                            $CreateSubjectDetails->ideal_ans1_status = $request->ideal_ans1_status;

							$CreateSubjectDetails->ideal_ans2 = $request->ideal_ans2;
                            $CreateSubjectDetails->ideal_ans2_status = $request->ideal_ans2_status;

							$CreateSubjectDetails->ideal_ans3 = $request->ideal_ans3;
                            $CreateSubjectDetails->ideal_ans3_status = $request->ideal_ans3_status;

							 $CreateSubjectDetails->ideal_ans4 = $request->ideal_ans4;
                            $CreateSubjectDetails->ideal_ans4_status = $request->ideal_ans4_status;

                            $CreateSubjectDetails->create_subject_id = $CreateSubject_id;
                            $CreateSubjectDetails->created_at = date('Y-m-d H:i:s');
                            $CreateSubjectDetails->updated_at = date('Y-m-d H:i:s');
                            $CreateSubjectDetails->save();

                        }else{
                           /* $CreateSubjectDetails = new CreateSubjectDetails();
                            $CreateSubjectDetails->question_number_id = $List_of_question['question_number_id'];
                            $CreateSubjectDetails->question_type_id = $List_of_question['question_type_id'];
                            $CreateSubjectDetails->question_part_id = $List_of_question['question_part_id'];
                            $CreateSubjectDetails->question_mark_id = $List_of_question['question_mark_id'];
                            $CreateSubjectDetails->question = $List_of_question['question'];
                            $CreateSubjectDetails->ideal_answer = $List_of_question['ideal_answer'];
                            $CreateSubjectDetails->ideal_answer_status = $List_of_question['ideal_answer_status'];
                            $CreateSubjectDetails->create_subject_id = $CreateSubject_id;
                            $CreateSubjectDetails->created_at = date('Y-m-d H:i:s');
                            $CreateSubjectDetails->updated_at = date('Y-m-d H:i:s');
                            $CreateSubjectDetails->save();*/

							$CreateSubjectDetails = new CreateSubjectDetails();
                            $CreateSubjectDetails->question_number_id = $request->question_number_id;
                            $CreateSubjectDetails->question_type_id = $request->question_type_id;
                            $CreateSubjectDetails->question_part_id = $request->question_part_id;
                            $CreateSubjectDetails->question_mark_id = $request->question_mark_id;
                            $CreateSubjectDetails->question = $request->question;

                            $CreateSubjectDetails->ideal_answer = $request->ideal_answer;
                            $CreateSubjectDetails->ideal_answer_status = $request->ideal_answer_status;

                            $CreateSubjectDetails->create_subject_id = $CreateSubject_id;
                            $CreateSubjectDetails->created_at = date('Y-m-d H:i:s');
                            $CreateSubjectDetails->updated_at = date('Y-m-d H:i:s');
                            $CreateSubjectDetails->save();
                        }

                   /* $List_of_question = $request->question_list;
                    $List_of_questions = json_decode($List_of_question,true);
                    foreach($List_of_questions as $List_of_question){
                        $question_part_id = $List_of_question['question_part_id'];

                    }    */
                    return response()->json([
                        'success' => true,
                        'data' => 'Subject Question data was generated.'
                    ]);
                }else{

					$question_number_id = $request->question_number_id;
					$question_type_id = $request->question_type_id;
					$question_part_id = $request->question_part_id;
					$question_mark_id = $request->question_mark_id;
					$question = $request->question;

                    $CreateSubject = new CreateSubject();
                    //$List_of_question = $request->question_list;
                    $CreateSubject->teacher_id = $request->teacher_id;
                    $CreateSubject->exam_details_id = $request->exam_details_id;
                    $CreateSubject->total_marks = $request->total_marks;
                    $CreateSubject->passed_marks = $request->passed_marks;
                    $CreateSubject->total_questions = $request->total_questions;
                    $CreateSubject->role_id = $request->role_id;
                    $CreateSubject->created_at = date('Y-m-d H:i:s');
                    $CreateSubject->updated_at = date('Y-m-d H:i:s');
                    $CreateSubject->save();
                    $CreateSubject_id = $CreateSubject->id;
                   /* $List_of_questions = json_decode($List_of_question,true);
                    foreach($List_of_questions as $List_of_question){
                        $question_part_id = $List_of_question['question_part_id'];
                        if($question_part_id == 1){
                            foreach($List_of_question['multiple'] as $mcq){
                                $CreateSubjectDetails = new CreateSubjectDetails();
                                $CreateSubjectDetails->question_number_id = $List_of_question['question_number_id'];
                                $CreateSubjectDetails->question_type_id = $List_of_question['question_type_id'];
                                $CreateSubjectDetails->question_part_id = $List_of_question['question_part_id'];
                                $CreateSubjectDetails->question_mark_id = $List_of_question['question_mark_id'];
                                $CreateSubjectDetails->question = $List_of_question['question'];
                                $CreateSubjectDetails->ideal_answer = $mcq['ideal_answer'];
                                $CreateSubjectDetails->ideal_answer_status = $mcq['ideal_answer_status'];
                                $CreateSubjectDetails->create_subject_id = $CreateSubject_id;
                                $CreateSubjectDetails->created_at = date('Y-m-d H:i:s');
                                $CreateSubjectDetails->updated_at = date('Y-m-d H:i:s');
                                $CreateSubjectDetails->save();
                            }
                        }else{
                            $CreateSubjectDetails = new CreateSubjectDetails();
                            $CreateSubjectDetails->question_number_id = $List_of_question['question_number_id'];
                            $CreateSubjectDetails->question_type_id = $List_of_question['question_type_id'];
                            $CreateSubjectDetails->question_part_id = $List_of_question['question_part_id'];
                            $CreateSubjectDetails->question_mark_id = $List_of_question['question_mark_id'];
                            $CreateSubjectDetails->question = $List_of_question['question'];
                            $CreateSubjectDetails->ideal_answer = $List_of_question['ideal_answer'];
                            $CreateSubjectDetails->ideal_answer_status = $List_of_question['ideal_answer_status'];
                            $CreateSubjectDetails->create_subject_id = $CreateSubject_id;
                            $CreateSubjectDetails->created_at = date('Y-m-d H:i:s');
                            $CreateSubjectDetails->updated_at = date('Y-m-d H:i:s');
                            $CreateSubjectDetails->save();
                        }
                    } */
						if($question_type_id == 1){

							$CreateSubjectDetails = new CreateSubjectDetails();
                            $CreateSubjectDetails->question_number_id = $request->question_number_id;
                            $CreateSubjectDetails->question_type_id = $request->question_type_id;
                            $CreateSubjectDetails->question_part_id = $request->question_part_id;
                            $CreateSubjectDetails->question_mark_id = $request->question_mark_id;
                            $CreateSubjectDetails->question = $request->question;

                            $CreateSubjectDetails->ideal_ans1 = $request->ideal_ans1;
                            $CreateSubjectDetails->ideal_ans1_status = $request->ideal_ans1_status;

							$CreateSubjectDetails->ideal_ans2 = $request->ideal_ans2;
                            $CreateSubjectDetails->ideal_ans2_status = $request->ideal_ans2_status;

							$CreateSubjectDetails->ideal_ans3 = $request->ideal_ans3;
                            $CreateSubjectDetails->ideal_ans3_status = $request->ideal_ans3_status;

							 $CreateSubjectDetails->ideal_ans4 = $request->ideal_ans4;
                            $CreateSubjectDetails->ideal_ans4_status = $request->ideal_ans4_status;

                            $CreateSubjectDetails->create_subject_id = $CreateSubject_id;
                            $CreateSubjectDetails->created_at = date('Y-m-d H:i:s');
                            $CreateSubjectDetails->updated_at = date('Y-m-d H:i:s');
                            $CreateSubjectDetails->save();

                        }else{
					//print_r($_REQUEST);
//die;
                           /* $CreateSubjectDetails = new CreateSubjectDetails();
                            $CreateSubjectDetails->question_number_id = $List_of_question['question_number_id'];
                            $CreateSubjectDetails->question_type_id = $List_of_question['question_type_id'];
                            $CreateSubjectDetails->question_part_id = $List_of_question['question_part_id'];
                            $CreateSubjectDetails->question_mark_id = $List_of_question['question_mark_id'];
                            $CreateSubjectDetails->question = $List_of_question['question'];
                            $CreateSubjectDetails->ideal_answer = $List_of_question['ideal_answer'];
                            $CreateSubjectDetails->ideal_answer_status = $List_of_question['ideal_answer_status'];
                            $CreateSubjectDetails->create_subject_id = $CreateSubject_id;
                            $CreateSubjectDetails->created_at = date('Y-m-d H:i:s');
                            $CreateSubjectDetails->updated_at = date('Y-m-d H:i:s');
                            $CreateSubjectDetails->save();*/

							$CreateSubjectDetails = new CreateSubjectDetails();
                            $CreateSubjectDetails->question_number_id = $request->question_number_id;
                            $CreateSubjectDetails->question_type_id = $request->question_type_id;
                            $CreateSubjectDetails->question_part_id = $request->question_part_id;
                            $CreateSubjectDetails->question_mark_id = $request->question_mark_id;
                            $CreateSubjectDetails->question = $request->question;

                            $CreateSubjectDetails->ideal_answer = $request->ideal_answer;
                            $CreateSubjectDetails->ideal_answer_status = $request->ideal_answer_status;

                            $CreateSubjectDetails->create_subject_id = $CreateSubject_id;
                            $CreateSubjectDetails->created_at = date('Y-m-d H:i:s');
                            $CreateSubjectDetails->updated_at = date('Y-m-d H:i:s');
                            $CreateSubjectDetails->save();
                        }
                    return response()->json([
                        'success' => true,
                        'data' => 'Subject Question data was generated.',
                        'exam_details_id'=>$request->exam_details_id,
                        'CreateSubject_id'=>$CreateSubject_id,
                    ]);
                }
        } catch (Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Oops! Something Went Wrong,  Please Try Again',
                ], 200);
        }
    }

    //answer sheet list
    public function answer_sheet_list(Request $request)
    {
        try {
                $AddAnswerSheet = AddAnswerSheet::select('add_answer_sheets.id','add_answer_sheets.sheet_name','add_answer_sheets.class_id','classes.class_name','add_answer_sheets.exam_name','add_answer_sheets.subject','add_answer_sheets.academic_year_id','academic_years.year_name',
                                                        'add_answer_sheets.semister_id','semesters.semester_name','add_answer_sheets.division_id','divisions.division_name','add_answer_sheets.role_id','add_answer_sheets.scanned_file'
                                                    )->
                                                    join('classes','classes.id','add_answer_sheets.class_id')->
                                                    join('divisions','divisions.id','add_answer_sheets.division_id')->
                                                    join('academic_years','academic_years.id','add_answer_sheets.academic_year_id')->
                                                    join('semesters','semesters.id','add_answer_sheets.semister_id')->
                                                    // where('add_answer_sheets.role_id', $role_id)->
                                                    orderby('add_answer_sheets.id','desc')->
                                                    get();
                    if(count($AddAnswerSheet)>0){
                        foreach ($AddAnswerSheet as $key => $value){
                            $images = explode (",", isset($value['scanned_file']) ? $value['scanned_file'] : null);
                            $scanned_files = str_replace( array( '\'','"',',','"','[', ']' ), '', $images);
                            $image_url = isset($scanned_files[0]) ? $scanned_files[0] :null;
                            $url = url('/');
                            $value['scanned_file'] = $url."/uploads/answer_sheet/scanned_file/".$image_url;
                        }
                        return response()->json([
                            'success' => true,
                            'data' => $AddAnswerSheet
                        ]);
                    }else{
                        $AddAnswerSheet = [];
                        return response()->json([
                            'success' => true,
                            'data' => $AddAnswerSheet
                        ]);
                    }
            } catch (Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Oops! Something Went Wrong,  Please Try Again',
                ], 200);
        }
    }

    //teacher dashboard list
    public function teacher_dashboard_list(Request $request)
    {
        try {
               $role_id = $request->role_id;
            if(!empty($role_id)){
                $teacher_dashboard = CreateSubject::select('create_subjects.teacher_id','create_subjects.exam_details_id','create_subjects.total_marks','create_subjects.passed_marks','create_subjects.total_questions',
                'create_subject_details.create_subject_id','create_subject_details.question_number_id','question_number_lists.question_number','create_subject_details.question_type_id','question_type_lists.question_type','create_subject_details.question_part_id','question_part_lists.question_part','create_subject_details.question_mark_id','question_mark_lists.question_mark','create_subject_details.question','create_subject_details.ideal_answer','create_subject_details.ideal_answer_status')->
                                                    join('create_subject_details','create_subject_details.create_subject_id','create_subjects.id')->
                                                    join('question_number_lists','question_number_lists.id','create_subject_details.question_number_id')->
                                                    join('question_type_lists','question_type_lists.id','create_subject_details.question_type_id')->
                                                    join('question_part_lists','question_part_lists.id','create_subject_details.question_part_id')->
                                                    join('question_mark_lists','question_mark_lists.id','create_subject_details.question_mark_id')->
                                                    where('create_subjects.role_id', $role_id)->
                                                    orderby('create_subjects.id','desc')->
                                                    get();
                return response()->json([
                    'success' => true,
                    'data' => isset($teacher_dashboard)?$teacher_dashboard:[],
                ]);
            }else{
                return response()->json([
                    'success' => true,
                    'data' => 'Please provide the Role ID.',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Oops! Something Went Wrong,  Please Try Again',
                ], 200);
        }
    }

    //Teacher create question list
    public function teacher_create_question_list(Request $request)
    {
        try {
            //    $role_id = $request->role_id;
               $CreateSubject_id = $request->CreateSubject_id;
               $question_type_id = $request->question_type_id;
            if(!empty($CreateSubject_id)){
                //if((!empty($CreateSubject_id)) && (!empty($question_type_id))){
			if((!empty($CreateSubject_id))){
                $teacher_create_question_list = CreateSubject::select('create_subjects.exam_details_id','create_subject_details.id as subject_details_id','create_subjects.total_marks','create_subjects.passed_marks','create_subjects.total_questions',
                                                                      'create_subject_details.create_subject_id','create_subject_details.question_number_id','question_number_lists.question_number','create_subject_details.question_type_id','question_type_lists.question_type','create_subject_details.question_part_id','question_part_lists.question_part','create_subject_details.question_mark_id','question_mark_lists.question_mark','create_subject_details.question','create_subject_details.ideal_answer',
																	  'create_subject_details.ideal_answer_status',
																	  'create_subject_details.ideal_ans1',
																	  'create_subject_details.ideal_ans1_status',
																	  'create_subject_details.ideal_ans2',
																	  'create_subject_details.ideal_ans2_status',
																	  'create_subject_details.ideal_ans3',
																	  'create_subject_details.ideal_ans3_status',
																	  'create_subject_details.ideal_ans4',
																	  'create_subject_details.ideal_ans4_status')->
                                                                join('create_subject_details','create_subject_details.create_subject_id','create_subjects.id')->
                                                                join('question_number_lists','question_number_lists.id','create_subject_details.question_number_id')->
                                                                join('question_type_lists','question_type_lists.id','create_subject_details.question_type_id')->
                                                                join('question_part_lists','question_part_lists.id','create_subject_details.question_part_id')->
                                                                join('question_mark_lists','question_mark_lists.id','create_subject_details.question_mark_id')->
                                                                where('create_subject_details.create_subject_id', $CreateSubject_id)->
                                                                //where('create_subject_details.question_type_id', $question_type_id)->
                                                                // where('create_subjects.role_id', $role_id)->
                                                                orderby('create_subject_details.id','desc')->
                                                                get();




                }
				/*else{
                    $teacher_create_question_list = CreateSubject::select('create_subjects.exam_details_id','create_subject_details.id as subject_details_id','create_subjects.total_marks','create_subjects.passed_marks','create_subjects.total_questions',
                                                                          'create_subject_details.create_subject_id','create_subject_details.question_number_id','question_number_lists.question_number','create_subject_details.question_type_id','question_type_lists.question_type','create_subject_details.question_part_id','question_part_lists.question_part','create_subject_details.question_mark_id','question_mark_lists.question_mark','create_subject_details.question','create_subject_details.ideal_answer','create_subject_details.ideal_answer_status')->
                                                                    join('create_subject_details','create_subject_details.create_subject_id','create_subjects.id')->
                                                                    join('question_number_lists','question_number_lists.id','create_subject_details.question_number_id')->
                                                                    join('question_type_lists','question_type_lists.id','create_subject_details.question_type_id')->
                                                                    join('question_part_lists','question_part_lists.id','create_subject_details.question_part_id')->
                                                                    join('question_mark_lists','question_mark_lists.id','create_subject_details.question_mark_id')->
                                                                    where('create_subject_details.create_subject_id', $CreateSubject_id)->
                                                                    where('create_subject_details.question_type_id','!=',1)->
                                                                    // where('create_subjects.role_id', $role_id)->
                                                                    orderby('create_subject_details.id','desc')->
                                                                    get();
                }*/
                return response()->json([
                    'success' => true,
                    'data' => isset($teacher_create_question_list)?$teacher_create_question_list:[],
                ]);
            }else{
                return response()->json([
                    'success' => true,
                    'data' => 'Please provide the CreateSubject ID.',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Oops! Something Went Wrong,  Please Try Again',
                ], 200);
        }
    }

    //get update subject details data
    public function update_subject_details(Request $request)
    {
        try {
                $question_number_id = $request->question_number_id;
                $question_type_id = $request->question_type_id;
                $question_part_id = $request->question_part_id;
                $question_mark_id = $request->question_mark_id;
                $question = $request->question;
                $ideal_answer = $request->ideal_answer;
                $ideal_answer_status = $request->ideal_answer_status;

				$ideal_ans1 = $request->ideal_ans1;
                $ideal_ans1_status = $request->ideal_ans1_status;

				$ideal_ans2 = $request->ideal_ans2;
                $ideal_ans2_status = $request->ideal_ans2_status;

				$ideal_ans3 = $request->ideal_ans3;
                $ideal_ans3_status = $request->ideal_ans3_status;

				$ideal_ans4 = $request->ideal_ans4;
                $ideal_ans4_status = $request->ideal_ans4_status;

                $subject_details_id = $request->subject_details_id;
                //get subject id
                $subject_id = CreateSubjectDetails::select('id')->
                                              where('id', $subject_details_id)->
                                              orderBy('id', 'DESC')->first();
                $subject_details_id = isset($subject_id->id) ? $subject_id->id : '';
                if(!empty($subject_details_id)){
                    //update subject details data
                    $subject_details_list = CreateSubjectDetails::where('id', $subject_details_id)->
                                                            update(['question_number_id' => $question_number_id,
                                                            'question_type_id' => $question_type_id,
                                                            'question_part_id' => $question_part_id,
                                                            'question_mark_id' => $question_mark_id,
                                                            'question' => $question,
                                                            'ideal_answer' => $ideal_answer,
                                                            'ideal_answer_status' => $ideal_answer_status,

															'ideal_ans1' => $ideal_ans1,
                                                            'ideal_ans1_status' => $ideal_ans1_status,
															'ideal_ans2' => $ideal_ans2,
                                                            'ideal_ans2_status' => $ideal_ans2_status,
															'ideal_ans3' => $ideal_ans3,
                                                            'ideal_ans3_status' => $ideal_ans3_status,
															'ideal_ans4' => $ideal_ans4,
                                                            'ideal_ans4_status' => $ideal_ans4_status,

                                                            'updated_at' => date('Y-m-d H:i:s')]);
                    $subject_details_list = "Subject data was updated successfully.";
                    return response()->json([
                        'success' => true,
                        'data' => $subject_details_list
                    ]);
                }else{
                    $subject_details_list = "subject ID could not be found.";
                    return response()->json([
                        'success' => true,
                        'data' => $subject_details_list
                    ]);
                }
        }catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Oops! Something Went Wrong,  Please Try Again',
            ], 200);
        }
    }

    //get delete subject details list
    public function delete_subject_details(Request $request)
    {
        try {
                $subject_details_id = $request->subject_details_id;
                //get subject id
                $subject_id = CreateSubjectDetails::select('id')->
                                              where('id', $subject_details_id)->
                                              orderBy('id', 'DESC')->first();
                $subject_details_id = isset($subject_id->id) ? $subject_id->id : '';
                if(!empty($subject_details_id)){
                    //delete subject details data
                    $subject_details_list = CreateSubjectDetails::where('id', $subject_details_id)->delete();
                    $subject_details_list = "subject data was Deleted successfully.";
                    return response()->json([
                        'success' => true,
                        'data' => $subject_details_list
                    ]);
                }else{
                    $subject_details_list = "subject ID could not be found.";
                    return response()->json([
                        'success' => true,
                        'data' => $subject_details_list
                    ]);
                }
        }catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Oops! Something Went Wrong,  Please Try Again',
            ], 200);
        }
    }

    //fetch Teacher create question list for edit
    public function fetch_create_question_list_for_edit(Request $request)
    {
        try {
            //    $role_id = $request->role_id;
               $subject_details_id = $request->subject_details_id;
               $question_type_id = $request->question_type_id;
            if(!empty($subject_details_id)){
                /*if((!empty($subject_details_id)) && (!empty($question_type_id))){
                    $create_question_list_for_edit = CreateSubject::select('create_subjects.exam_details_id','create_subject_details.id as subject_details_id','create_subjects.total_marks','create_subjects.passed_marks','create_subjects.total_questions',
                                                                           'create_subject_details.create_subject_id','create_subject_details.question_number_id','question_number_lists.question_number','create_subject_details.question_type_id','question_type_lists.question_type','create_subject_details.question_part_id','question_part_lists.question_part','create_subject_details.question_mark_id','question_mark_lists.question_mark','create_subject_details.question','create_subject_details.ideal_answer','create_subject_details.ideal_answer_status')->
                                                                    join('create_subject_details','create_subject_details.create_subject_id','create_subjects.id')->
                                                                    join('question_number_lists','question_number_lists.id','create_subject_details.question_number_id')->
                                                                    join('question_type_lists','question_type_lists.id','create_subject_details.question_type_id')->
                                                                    join('question_part_lists','question_part_lists.id','create_subject_details.question_part_id')->
                                                                    join('question_mark_lists','question_mark_lists.id','create_subject_details.question_mark_id')->
                                                                    where('create_subject_details.create_subject_id', $subject_details_id)->
                                                                    where('create_subject_details.question_type_id', $question_type_id)->
                                                                    // where('create_subjects.role_id', $role_id)->
                                                                    orderby('create_subject_details.id','desc')->
                                                                    get();
                }else{*/
                $create_question_list_for_edit = CreateSubject::select('create_subjects.exam_details_id','create_subject_details.id as subject_details_id','create_subjects.total_marks','create_subjects.passed_marks','create_subjects.total_questions',
                                                                       'create_subject_details.create_subject_id','create_subject_details.question_number_id','question_number_lists.question_number','create_subject_details.question_type_id','question_type_lists.question_type','create_subject_details.question_part_id','question_part_lists.question_part','create_subject_details.question_mark_id','question_mark_lists.question_mark','create_subject_details.question','create_subject_details.ideal_answer','create_subject_details.ideal_answer_status',
																	   'create_subject_details.ideal_ans1',
																	  'create_subject_details.ideal_ans1_status',
																	  'create_subject_details.ideal_ans2',
																	  'create_subject_details.ideal_ans2_status',
																	  'create_subject_details.ideal_ans3',
																	  'create_subject_details.ideal_ans3_status',
																	  'create_subject_details.ideal_ans4',
																	  'create_subject_details.ideal_ans4_status')->
                                                                join('create_subject_details','create_subject_details.create_subject_id','create_subjects.id')->
                                                                join('question_number_lists','question_number_lists.id','create_subject_details.question_number_id')->
                                                                join('question_type_lists','question_type_lists.id','create_subject_details.question_type_id')->
                                                                join('question_part_lists','question_part_lists.id','create_subject_details.question_part_id')->
                                                                join('question_mark_lists','question_mark_lists.id','create_subject_details.question_mark_id')->
                                                                where('create_subject_details.id', $subject_details_id)->
                                                                // where('create_subjects.role_id', $role_id)->
                                                                orderby('create_subject_details.id','desc')->
                                                                get();
               /* }*/
                return response()->json([
                    'success' => true,
                    'data' => isset($create_question_list_for_edit)?$create_question_list_for_edit:[],
                ]);
            }else{
                return response()->json([
                    'success' => true,
                    'data' => 'Please provide the CreateSubject ID.',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Oops! Something Went Wrong,  Please Try Again',
                ], 200);
        }
    }

    //fetch question paper managment list
    public function question_paper_managment_list(Request $request)
    {
        try {
                $role_id = $request->role_id;
                if(!empty($role_id)){
                $question_paper_managment_list = CreateSubject::select('create_subjects.id as create_subjects','create_subjects.exam_details_id','create_subjects.teacher_id','users.name','create_exam_details.subject_name','create_exams.class_id','classes.class_name','create_exams.division_id','divisions.division_name','create_subjects.created_at')->
                                                                join('create_subject_details','create_subject_details.create_subject_id','create_subjects.id')->
                                                                join('create_exams','create_exams.id','create_subjects.exam_details_id')->
                                                                join('create_exam_details','create_exam_details.create_exam_id','create_exams.id')->
                                                                join('classes','classes.id','create_exams.class_id')->
                                                                join('divisions','divisions.id','create_exams.division_id')->
                                                                join('users','users.id','create_subjects.teacher_id')->
                                                                where('create_subjects.role_id', $role_id)->
                                                                orderby('create_subjects.id','desc')->
                                                                get();
                return response()->json([
                    'success' => true,
                    'data' => isset($question_paper_managment_list)?$question_paper_managment_list:[],
                ]);
            }else{
                return response()->json([
                    'success' => true,
                    'data' => 'Please provide the Role ID.',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Oops! Something Went Wrong,  Please Try Again',
                ], 200);
        }
    }

    // //fetch question paper managment list
    // public function details_question_paper_managment_list(Request $request)
    // {
    //     try {
    //             $role_id = $request->role_id;
    //             if(!empty($role_id)){
    //             $question_paper_managment_list = CreateSubject::select('create_subjects.id as create_subjects_id','create_subjects.exam_details_id','create_exam_details.subject_name','create_exams.class_id','classes.class_name','create_exams.division_id','divisions.division_name','create_subjects.created_at')->
    //                                                             join('create_subject_details','create_subject_details.create_subject_id','create_subjects.id','create_subjects.teacher_id','users.name')->
    //                                                             join('create_exams','create_exams.id','create_subjects.exam_details_id')->
    //                                                             join('create_exam_details','create_exam_details.create_exam_id','create_exams.id')->
    //                                                             join('classes','classes.id','create_exams.class_id')->
    //                                                             join('divisions','divisions.id','create_exams.division_id')->
    //                                                             where('create_subjects.role_id', $role_id)->
    //                                                             orderby('create_subjects.id','desc')->
    //                                                             get();
    //             return response()->json([
    //                 'success' => true,
    //                 'data' => isset($question_paper_managment_list)?$question_paper_managment_list:[],
    //             ]);
    //         }else{
    //             return response()->json([
    //                 'success' => true,
    //                 'data' => 'Please provide the Role ID.',
    //             ]);
    //         }
    //     } catch (Exception $e) {
    //         return response()->json([
    //                 'success' => false,
    //                 'message' => 'Oops! Something Went Wrong,  Please Try Again',
    //             ], 200);
    //     }
    // }

    //Assign Teacher to Answer Sheet
    public function assign_teacher_to_asheet(Request $request)
    {
        try {
                $sheet_name=$request->sheet_name;
                $assigned_by_examiner=$request->assigned_by_examiner;
                $teacher_id=$request->teacher_id;
				$class_id=$request->class_id;
				$academic_year_id=$request->academic_year_id;
				$division_id=$request->division_id;
				$subject=$request->subject;

                $teacher_id_data=AssignedTeacher::where('sheet_name',$sheet_name)->where('teacher_id',$teacher_id)->first();
                if(!empty($teacher_id_data))
                {
                    return response()->json([
                        'success' => false,
                        'data' => 'Teacher Already Assigned to Answer Sheet.',
                    ]);
                }
               else if (!empty($sheet_name)) {
                    $data=[
                        'assigned_sheet_id'=>$request->assigned_sheet_id,
                        'teacher_id'=>$teacher_id,
                        'assigned_by_examiner'=>$assigned_by_examiner,
                        'sheet_path'=>"uploads/answer_sheet/$sheet_name",
                        'sheet_name'=>$sheet_name,
						'class_id'=>$class_id,
						'academic_year_id'=>$academic_year_id,
						'division_id'=>$division_id,
						'subject'=>$subject,
                    ];
                    if(AssignedTeacher::create($data)){
                        return response()->json([
                            'success' => true,
                            'data' => 'Teacher Assigned to Answer Sheet.',
                        ]);
                    }
                }
                else{
                return response()->json([
                    'success' => false,
                    'data' => 'Please provide the Sheet Name.',
                ]);
            }

        }
        catch (Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Oops! Something Went Wrong,  Please Try Again',
                ], 200);
        }
    }

    // Get Teacher List Assigned to Answer Sheet
    public function get_assigned_teacher_list1()
    {
        try {
            //$assigned_teacher_list = AssignedTeacher::select('*')->orderby('id','desc')->get();
			$assigned_teacher_list = DB::select("select *, (select class_name from classes where classes.id = assigned_teachers.class_id) as class_name
			 , (select division_name from divisions where divisions.id = assigned_teachers.division_id) as division_name , (select year_name from academic_years where academic_years.id = assigned_teachers.academic_year_id) as year_name from assigned_teachers order by id desc");


			$assigned_file_list = '';
                foreach ($assigned_teacher_list as $key => $value){
					//echo $dir = base_path("uploads/answer_sheet/".$value->sheet_name);

					$assigned_file_list = DB::select("select scanned_file from add_answer_sheets where sheet_name = '".$value->sheet_name."'");




                }


            if(count($assigned_teacher_list)>0){
                return response()->json([
                    'success' => true,
                    'data' => $assigned_teacher_list,
					'file' => $assigned_file_list
                ]);
            }else{
                $QuestionNumberList = [];
                return response()->json([
                    'success' => true,
                    'data' => $assigned_teacher_list
                ]);
            }
    }catch(Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Oops! Something Went Wrong,  Please Try Again',
        ], 200);
    }
    }

	public function get_assigned_teacher_list()
    {
        try {

			 $assigned_teacher_list = DB::select("select *, (select class_name from classes where classes.id = assigned_teachers.class_id) as class_name
			 , (select division_name from divisions where divisions.id = assigned_teachers.division_id) as division_name , (select year_name from academic_years where academic_years.id = assigned_teachers.academic_year_id) as year_name from assigned_teachers order by id desc");
             //$assigned_examiner_list = AssignedSheet::select('assigned_sheets.assigned_by_scanner','assigned_sheets.sheet_path','assigned_sheets.sheet_name'
			 //,(DB::raw("select class_name from classes where classes.id=assigned_sheets.class_id")))->
			//											orderby('assigned_sheets.id','desc')->get();



			 $assigned_teacher_list= json_decode(json_encode($assigned_teacher_list),true);
            $i=0;
                foreach ($assigned_teacher_list as $key => $value){
					//echo $dir = base_path("uploads/answer_sheet/".$value->sheet_name);
					$assigned_file_list = DB::select("select scanned_file from add_answer_sheets where sheet_name = '".$value['sheet_name']."'");
                   $assigned_file_list= json_decode(json_encode($assigned_file_list),true);
$file_data=[];
                    $k=0;
                    foreach ($assigned_file_list as $row)
                    {
                        $file_data[$k]=$row;
                        $k++;
                    }
                    $assigned_teacher_list[$i]['file_data']=$file_data;
                    $i++;
                }

             if(count($assigned_teacher_list)>0){
                 return response()->json([
                     'success' => true,
                     'data' => $assigned_teacher_list
                 ]);
             }else{
                 $QuestionNumberList = [];
                 return response()->json([
                     'success' => true,
                     'data' => $assigned_teacher_list
                 ]);
             }
     }catch(Exception $e) {
         return response()->json([
             'success' => false,
             'message' => 'Oops! Something Went Wrong,  Please Try Again',
         ], 200);
     }
    }


public function get_answersheet_data_by_id(Request $request)
    {
        try {

			$answersheet_name=$request->sheet_name;

			$answer_data = DB::select("select *, (select class_name from classes where classes.id = add_answer_sheets.class_id) as class_name
			 , (select division_name from divisions where divisions.id = add_answer_sheets.division_id) as division_name , (select year_name from academic_years where academic_years.id = add_answer_sheets.academic_year_id) as year_name from add_answer_sheets where sheet_name = '".$answersheet_name."' order by id desc Limit 1");

			$sheet_name = $answer_data[0]->sheet_name;


			$file_list = DB::select("select scanned_file from add_answer_sheets where sheet_name = '".$sheet_name."'");

            if(count($answer_data)>0){
                return response()->json([
                    'success' => true,
                    'data' => $answer_data,
					'file' => $file_list,
                ]);
            }else{
                $QuestionNumberList = [];
                return response()->json([
                    'success' => true,
                    'data' => $answer_data
                ]);
            }
    }catch(Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Oops! Something Went Wrong,  Please Try Again',
        ], 200);
    }
    }


	public function pdf_generate($id)
    {

        // Setup a filename
        $documentFileName = "fun.pdf";

		$exam_detail = DB::table('create_subjects')->select('create_exams.class_id','classes.class_name','create_subjects.exam_details_id','create_exams.exam_name','create_exam_details.exam_date','create_exam_details.subject_name',
		'create_exam_details.total_mark','create_exam_details.exam_time')->
							 join('create_exam_details','create_exam_details.id','create_subjects.exam_details_id')->
							  join('create_exams','create_exams.id','create_exam_details.create_exam_id')->
							 join('classes','classes.id','create_exams.class_id')

							 ->where('create_subjects.id', $id)
							 ->get();



		$data = DB::table('create_subjects')->select('create_subjects.exam_details_id','create_subject_details.id as subject_details_id','create_subjects.total_marks','create_subjects.passed_marks','create_subjects.total_questions',
					  'create_subject_details.create_subject_id','create_subject_details.question_number_id','question_number_lists.question_number','create_subject_details.question_type_id','question_type_lists.question_type','create_subject_details.question_part_id','question_part_lists.question_part','create_subject_details.question_mark_id','question_mark_lists.question_mark','create_subject_details.question','create_subject_details.ideal_answer',
					  'create_subject_details.ideal_answer_status',
					  'create_subject_details.ideal_ans1',
					  'create_subject_details.ideal_ans1_status',
					  'create_subject_details.ideal_ans2',
					  'create_subject_details.ideal_ans2_status',
					  'create_subject_details.ideal_ans3',
					  'create_subject_details.ideal_ans3_status',
					  'create_subject_details.ideal_ans4',
					  'create_subject_details.ideal_ans4_status')->
				join('create_subject_details','create_subject_details.create_subject_id','create_subjects.id')->
				join('question_number_lists','question_number_lists.id','create_subject_details.question_number_id')->
				join('question_type_lists','question_type_lists.id','create_subject_details.question_type_id')->
				join('question_part_lists','question_part_lists.id','create_subject_details.question_part_id')->
				join('question_mark_lists','question_mark_lists.id','create_subject_details.question_mark_id')->
				where('create_subject_details.create_subject_id', $id)->

				orderby('create_subject_details.id','desc')->
				get();


		//$data = ['1','2'];
		//$html = return view('pdf');
        //$html = PDF::loadView('pdf', $data);


        // Create the mPDF document
        $document = new PDF( [
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_header' => '3',
            'margin_top' => '20',
            'margin_bottom' => '20',
            'margin_footer' => '2',
        ]);

        // Set some header informations for output
        $header = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$documentFileName.'"'
        ];

        // Write some simple Content
        //$document->WriteHTML('<h1 style="color:blue">TheCodingJack</h1>');
        $document->WriteHTML(view('pdf',compact('exam_detail','data')));

		 $document->Output("demo.pdf", "D");
        // Save PDF on your public storage
       // Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, "S"));

        // Get file back from storage with the give header informations
       // return Storage::disk('public')->download($documentFileName, 'Request', $header); //
    }
}
