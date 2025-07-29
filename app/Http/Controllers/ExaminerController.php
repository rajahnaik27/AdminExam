<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\Division;
use App\Models\Semester;
use App\Models\AcademicYear;
use App\Models\CreateExam;
use App\Models\CreateExamDetails;
use App\Models\QuestionPaperSet;
use App\Models\AnswerPaperSet;
use App\Models\AssignedSheet;

class ExaminerController extends Controller
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
    
    //get Class name list 
    public function get_class_name_list(Request $request)
    {
        try {
                $ClassList = Classes::select('id','class_name')->get();
				if(count($ClassList)>0){                         
					return response()->json([
						'success' => true,
						'data' => $ClassList
					]);
				}else{
					$ClassList = [];                        
					return response()->json([
						'success' => true,
						'data' => $ClassList
					]);
				}
        }catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Oops! Something Went Wrong,  Please Try Again',
            ], 200);
        }
    }

    //get division name list
    public function get_division_name_list(Request $request)
    {
        try {
                $DivisionList = Division::select('id','division_name')->get();
				if(count($DivisionList)>0){                         
					return response()->json([
						'success' => true,
						'data' => $DivisionList
					]);
				}else{
					$DivisionList = [];                        
					return response()->json([
						'success' => true,
						'data' => $DivisionList
					]);
				}
        }catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Oops! Something Went Wrong,  Please Try Again',
            ], 200);
        }
    }

    //get semester name list
    public function get_semester_name_list(Request $request)
    {
        try {
                $SemesterList = Semester::select('id','semester_name')->get();
				if(count($SemesterList)>0){                         
					return response()->json([
						'success' => true,
						'data' => $SemesterList
					]);
				}else{
					$SemesterList = [];                        
					return response()->json([
						'success' => true,
						'data' => $SemesterList
					]);
				}
        }catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Oops! Something Went Wrong,  Please Try Again',
            ], 200);
        }
    }

    //get academic year list
    public function get_academic_year_list(Request $request)
    {
        try {
                $AcademicYearList = AcademicYear::select('id','year_name')->get();
				if(count($AcademicYearList)>0){                         
					return response()->json([
						'success' => true,
						'data' => $AcademicYearList
					]);
				}else{
					$AcademicYearList = [];                        
					return response()->json([
						'success' => true,
						'data' => $AcademicYearList
					]);
				}
        }catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Oops! Something Went Wrong,  Please Try Again',
            ], 200);
        }
    }

    //get question paper list 
    public function get_question_paper_list(Request $request)
    {
        try {
                $QuestionPaperSet = QuestionPaperSet::select('id','question_paper_name')->get();
				if(count($QuestionPaperSet)>0){                         
					return response()->json([
						'success' => true,
						'data' => $QuestionPaperSet
					]);
				}else{
					$QuestionPaperSet = [];                        
					return response()->json([
						'success' => true,
						'data' => $QuestionPaperSet
					]);
				}
        }catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Oops! Something Went Wrong,  Please Try Again',
            ], 200);
        }
    }

    //get answer paper list
    public function get_answer_paper_list(Request $request)
    {
        try {
                $AnswerPaperSet = AnswerPaperSet::select('id','answer_paper_name')->get();
				if(count($AnswerPaperSet)>0){                         
					return response()->json([
						'success' => true,
						'data' => $AnswerPaperSet
					]);
				}else{
					$AnswerPaperSet = [];                        
					return response()->json([
						'success' => true,
						'data' => $AnswerPaperSet
					]);
				}
        }catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Oops! Something Went Wrong,  Please Try Again',
            ], 200);
        }
    }

    //add Exam data
    public function create_exam(Request $request){
        try {
                $create_exam = new CreateExam();
                $List_of_subject = $request->subject_list;                
                $create_exam->exam_name = $request->exam_name;
                $create_exam->class_id = $request->class_id;
                $create_exam->division_id = $request->division_id;
                $create_exam->academic_year_id = $request->academic_year_id;
                $create_exam->semister_id = $request->semister_id;
                $create_exam->role_id = $request->role_id;
                $create_exam->exam_start_date = date('Y-m-d', strtotime($request->exam_start_date));
                $create_exam->exam_end_date = date('Y-m-d', strtotime($request->exam_end_date));
                $create_exam->created_at = date('Y-m-d H:i:s');
                $create_exam->updated_at = date('Y-m-d H:i:s'); 
                $create_exam->save();
                $create_exam_id = $create_exam->id;

                $List_of_subjects = json_decode($List_of_subject,true); 
                foreach($List_of_subjects as $list_of_subject){   
                    $CreateExamDetails = new CreateExamDetails();                      
                    $CreateExamDetails->subject_name = $list_of_subject['subject_name'];
                    $CreateExamDetails->total_mark = $list_of_subject['total_mark'];
                    $CreateExamDetails->pass_mark = $list_of_subject['pass_mark'];
                    $CreateExamDetails->exam_date = $list_of_subject['exam_date'];
                    $CreateExamDetails->select_question_paper_id = $list_of_subject['select_question_paper_id'];
                    $CreateExamDetails->select_answer_paper_id = $list_of_subject['select_answer_paper_id'];
                    $CreateExamDetails->exam_time = $list_of_subject['exam_time'];
                    $CreateExamDetails->create_exam_id = $create_exam_id;
                    $CreateExamDetails->created_at = date('Y-m-d H:i:s');
                    $CreateExamDetails->updated_at = date('Y-m-d H:i:s');       
                    $CreateExamDetails->save();
                }       
                return response()->json([
                    'success' => true,
                    'data' => 'Exam data was generated.',
                ]);               

        } catch (Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Oops! Something Went Wrong,  Please Try Again',
                ], 200);
        }
    }

    //get Create Exam details list
    public function get_exam_details(Request $request)
    {
        try {
                $exam_details_list = CreateExamDetails::select('create_exam_details.id as exam_details_id','create_exams.exam_name','classes.class_name','create_exams.class_id','divisions.division_name','create_exams.division_id','academic_years.year_name','create_exams.academic_year_id','semesters.semester_name','create_exams.semister_id','create_exams.exam_start_date','create_exams.exam_end_date',
                                                            'create_exam_details.create_exam_id','create_exam_details.subject_name','create_exam_details.total_mark','create_exam_details.pass_mark','create_exam_details.exam_date','question_paper_sets.question_paper_name','create_exam_details.select_question_paper_id','answer_paper_sets.answer_paper_name','create_exam_details.select_answer_paper_id','create_exam_details.exam_time')->
                                                        join('create_exams','create_exams.id','create_exam_details.create_exam_id')->
                                                        join('classes','classes.id','create_exams.class_id')->
                                                        join('divisions','divisions.id','create_exams.division_id')->
                                                        join('academic_years','academic_years.id','create_exams.academic_year_id')->
                                                        join('semesters','semesters.id','create_exams.semister_id')->
                                                        join('question_paper_sets','question_paper_sets.id','create_exam_details.select_question_paper_id')->
                                                        join('answer_paper_sets','answer_paper_sets.id','create_exam_details.select_answer_paper_id')->
                                                        orderby('create_exam_details.id','desc')->
                                                        get();
				if(count($exam_details_list)>0){                         
					return response()->json([
						'success' => true,
						'data' => $exam_details_list
					]);
				}else{
					$exam_details_list = [];                        
					return response()->json([
						'success' => true,
						'data' => $exam_details_list
					]);
				}
        }catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Oops! Something Went Wrong,  Please Try Again',
            ], 200);
        }
    }

    //fetch exam data for edit 
    public function get_edit_exam_data(Request $request)
    {
        try {
                $create_exam_id = $request->create_exam_id;
                $exam_details_id = $request->exam_details_id;
                $get_edit_exam_data = CreateExamDetails::select('create_exam_details.id as exam_details_id','create_exams.exam_name','classes.class_name','create_exams.class_id','divisions.division_name','create_exams.division_id','academic_years.year_name','create_exams.academic_year_id','semesters.semester_name','create_exams.semister_id','create_exams.exam_start_date','create_exams.exam_end_date',
                                                            'create_exam_details.create_exam_id','create_exam_details.subject_name','create_exam_details.total_mark','create_exam_details.pass_mark','create_exam_details.exam_date','question_paper_sets.question_paper_name','create_exam_details.select_question_paper_id','answer_paper_sets.answer_paper_name','create_exam_details.select_answer_paper_id','create_exam_details.exam_time')->
                                                        join('create_exams','create_exams.id','create_exam_details.create_exam_id')->
                                                        join('classes','classes.id','create_exams.class_id')->
                                                        join('divisions','divisions.id','create_exams.division_id')->
                                                        join('academic_years','academic_years.id','create_exams.academic_year_id')->
                                                        join('semesters','semesters.id','create_exams.semister_id')->
                                                        join('question_paper_sets','question_paper_sets.id','create_exam_details.select_question_paper_id')->
                                                        join('answer_paper_sets','answer_paper_sets.id','create_exam_details.select_answer_paper_id')->
                                                        where('create_exam_details.id', $exam_details_id)->
                                                        where('create_exam_details.create_exam_id', $create_exam_id)->
                                                        get();
				if(count($get_edit_exam_data)>0){                         
					return response()->json([
						'success' => true,
						'data' => $get_edit_exam_data
					]);
				}else{
					$get_edit_exam_data = [];                        
					return response()->json([
						'success' => true,
						'data' => $get_edit_exam_data
					]);
				}
        }catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Oops! Something Went Wrong,  Please Try Again',
            ], 200);
        }
    }

    //fetch create_exam_id edit 
    public function get_create_exam_id(Request $request)
    {
        try {
                $exam_details_id = $request->exam_details_id;
                $get_edit_exam_data = CreateExamDetails::select('create_exam_details.create_exam_id')->
                                                        join('create_exams','create_exams.id','create_exam_details.create_exam_id')->
                                                        where('create_exam_details.id', $exam_details_id)->
                                                        get();
				if(count($get_edit_exam_data)>0){                         
					return response()->json([
						'success' => true,
						'data' => $get_edit_exam_data
					]);
				}else{
					$get_edit_exam_data = [];                        
					return response()->json([
						'success' => true,
						'data' => $get_edit_exam_data
					]);
				}
        }catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Oops! Something Went Wrong,  Please Try Again',
            ], 200);
        }
    }
    //get update Exam details list
    public function update_exam_details(Request $request)
    {
        try {
                $exam_details_id = $request->exam_details_id;
                $exam_name = $request->exam_name;
                $class_id = $request->class_id;
                $division_id = $request->division_id;
                $academic_year_id = $request->academic_year_id;                
                $semister_id = $request->semister_id;
                $exam_start_date = date("Y-m-d", strtotime($request->exam_start_date));
                $exam_end_date = date("Y-m-d", strtotime($request->exam_end_date));
                
                $subject_name = $request->subject_name;
                $total_mark = $request->total_mark;
                $pass_mark = $request->pass_mark;
                $date = $request->exam_date;
                $exam_dates = date("Y-m-d", strtotime($date));
                $select_question_paper_id = $request->select_question_paper_id;
                $select_answer_paper_id = $request->select_answer_paper_id;
                $exam_time = $request->exam_time;

                //get exam id 
                $exam_id = CreateExamDetails::select('create_exam_id')->
                                              where('id', $exam_details_id)->
                                              orderBy('id', 'DESC')->first();
                $create_exam_id = isset($exam_id->create_exam_id) ? $exam_id->create_exam_id : '';
                if(!empty($create_exam_id)){
                    //update exam data
                    $exam_details_list = CreateExam::where('id', $create_exam_id)->
                                                    update(['exam_name' => $exam_name,
                                                        'class_id' => $class_id,
                                                        'division_id' => $division_id,
                                                        'academic_year_id' => $academic_year_id,
                                                        'semister_id' => $semister_id,
                                                        'exam_start_date' => $exam_start_date,
                                                        'exam_end_date' => $exam_end_date,
                                                        'updated_at' => date('Y-m-d H:i:s')]);                                                    
                    //update exam details data
                    $exam_details_list = CreateExamDetails::where('id', $exam_details_id)->
                                                            update(['exam_date' => $exam_dates,
                                                            'subject_name' => $subject_name,
                                                            'total_mark' => $total_mark,
                                                            'pass_mark' => $pass_mark,
                                                            'select_question_paper_id' => $select_question_paper_id,
                                                            'select_answer_paper_id' => $select_answer_paper_id,
                                                            'exam_time' => $exam_time,
                                                            'updated_at' => date('Y-m-d H:i:s')]);
                    $exam_details_list = "Exam data was updated successfully.";                      
                    return response()->json([
                        'success' => true,
                        'data' => $exam_details_list
                    ]);
                }else{
                    $exam_details_list = "Exam ID could not be found.";                      
                    return response()->json([
                        'success' => true,
                        'data' => $exam_details_list
                    ]);
                }
                
				
        }catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Oops! Something Went Wrong,  Please Try Again',
            ], 200);
        }
    }

    //get delete Exam details list
    public function delete_exam_details(Request $request)
    {
        try {
                $exam_details_id = $request->exam_details_id;
                //get exam id 
                $exam_id = CreateExamDetails::select('create_exam_id')->
                                              where('id', $exam_details_id)->
                                              orderBy('id', 'DESC')->first();
                $create_exam_id = isset($exam_id->create_exam_id) ? $exam_id->create_exam_id : '';
                if(!empty($create_exam_id)){
                    //delete exam data
                    //$exam_details_list = CreateExam::where('id', $create_exam_id)->delete();                                                    
                    //delete exam details data
                    $exam_details_list = CreateExamDetails::where('id', $exam_details_id)->delete();
                    $exam_details_list = "Exam data was Deleted successfully.";  
                    return response()->json([
                        'success' => true,
                        'data' => $exam_details_list
                    ]);
                }else{
                    $exam_details_list = "Exam ID could not be found.";                      
                    return response()->json([
                        'success' => true,
                        'data' => $exam_details_list
                    ]);
                }               
        }catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Oops! Something Went Wrong,  Please Try Again',
            ], 200);
        }
    }

     // Get Examiner List Assigned to Answer Sheet
     public function get_assigned_examiner_list()
     {
         try {
			 
			 $assigned_teacher_list = DB::select("select *, (select class_name from classes where classes.id = assigned_sheets.class_id) as class_name 
			 , (select division_name from divisions where divisions.id = assigned_sheets.division_id) as division_name , (select year_name from academic_years where academic_years.id = assigned_sheets.academic_year_id) as year_name from assigned_sheets order by id desc");	
             //$assigned_examiner_list = AssignedSheet::select('assigned_sheets.assigned_by_scanner','assigned_sheets.sheet_path','assigned_sheets.sheet_name'
			 //,(DB::raw("select class_name from classes where classes.id=assigned_sheets.class_id")))->
			//											orderby('assigned_sheets.id','desc')->get();
			
			
			
			 $assigned_teacher_list= json_decode(json_encode($assigned_teacher_list),true);
            $i=0;
                foreach ($assigned_teacher_list as $key => $value){
					//echo $dir = base_path("uploads/answer_sheet/".$value->sheet_name);	
					$assigned_file_list = DB::select("select scanned_file from add_answer_sheets where sheet_name = '".$value['sheet_name']."'");
                   $assigned_file_list= json_decode(json_encode($assigned_file_list),true);

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
     
}
