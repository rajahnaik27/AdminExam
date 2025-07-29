<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ScannerProfile;
use App\Models\AddAnswerSheet;
use App\Models\AssignedSheet;

class ScannerController extends Controller
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

    //add answer sheet details
    public function add_answer_sheet(Request $request){
        try {
                
                
                $sheet_name = $request->sheet_name;
            $answersheet_name=AddAnswerSheet::where('sheet_name',$sheet_name)->first();

                if (!empty($answersheet_name)) {
                    return response()->json([
                        'success' => false,
                        'data' => 'Folder Name Exists.',
                        ]); 
                }
                else{
                $class_id = $request->class_id;
                $exam_name = $request->exam_name;
                $subject = $request->subject;
                $academic_year_id = $request->academic_year_id;
                $semister_id = $request->semister_id;
                $division_id = $request->division_id;
                $role_id = $request->role_id;          
                $scanned_file_data[] = $request->scanned_file;              
                $today = date('Ymdhis');
                $name = $request->name;
                //scanned_file and move file to folder 
                $AnswersheetData = [];
                foreach($scanned_file_data as $scanned_fileData){
                    foreach($scanned_fileData as $scanned_file){  
                            $upload_path = base_path("uploads/answer_sheet/$sheet_name");
                            $scanned_file_name = 'scanned_file'.rand().$today.''.$name.'.'.$scanned_file->getClientOriginalExtension();		
                            $scanned_file->move($upload_path,$scanned_file_name);
                            array_push($AnswersheetData,$scanned_file_name); 
                    } 
                }                
                foreach ($AnswersheetData as $Answersheet) { 
                    $AddAnswerSheet = new AddAnswerSheet();
                    $AddAnswerSheet->sheet_name = $sheet_name;
                    $AddAnswerSheet->class_id = $class_id;
                    $AddAnswerSheet->exam_name = $exam_name;
                    $AddAnswerSheet->subject = $subject;
                    $AddAnswerSheet->academic_year_id = $academic_year_id;
                    $AddAnswerSheet->semister_id = $semister_id;
                    $AddAnswerSheet->division_id = $division_id;
                    $AddAnswerSheet->role_id = $role_id;                
                    $AddAnswerSheet->created_at = date('Y-m-d H:i:s');
                    $AddAnswerSheet->updated_at = date('Y-m-d H:i:s');
                    $Answersheet = isset($Answersheet)?$Answersheet:''; 
                    $AddAnswerSheet->scanned_file = $Answersheet;
                    $AddAnswerSheet->save();                        
                }   
                return response()->json([
                    'success' => true,
                    'data' => 'Details from the answer sheet were successfully added.',
                    ]); 
                }
                                    
        } catch (Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Oops! Something Went Wrong,  Please Try Again',
                ], 200);
        }
    }

    //add scanner profile data
    public function add_scanner_profile(Request $request)
    {
        try {
                $get_email = ScannerProfile::select('email_id')->where('email_id',$request->email_id)->orderBy('id', 'DESC')->first();
                $email_id = isset($get_email->email_id)?$get_email->email_id:'';
                if($email_id != $request->email_id){
                    $get_phone_no = ScannerProfile::select('phone_no')->where('phone_no',$request->phone_no)->orderBy('id', 'DESC')->first();
                    $phone_no = isset($get_phone_no->phone_no)?$get_phone_no->phone_no:'';
                    if($phone_no != $request->phone_no){
                        $get_employee_id = ScannerProfile::select('employee_id')->where('employee_id',$request->employee_id)->orderBy('id', 'DESC')->first();
                        $employee_id = isset($get_employee_id->employee_id)?$get_employee_id->employee_id:'';
                        if($employee_id != $request->employee_id){
                            $ScannerProfile = new ScannerProfile();               
                            $ScannerProfile->name = $request->name;
                            $ScannerProfile->employee_id = $request->employee_id;
                            $ScannerProfile->phone_no = $request->phone_no;
                            $ScannerProfile->date_of_joining = date('Y-m-d', strtotime($request->date_of_joining));
                            $ScannerProfile->email_id = $request->email_id;
                            $ScannerProfile->role_id = $request->role_id;
                            $ScannerProfile->city = $request->city;
                            $ScannerProfile->state = $request->state;
                            $ScannerProfile->country = $request->country;
                            $profile_pic = $request->profile_pic;
                            $ScannerProfile->created_at = date('Y-m-d H:i:s');
                            $ScannerProfile->updated_at = date('Y-m-d H:i:s');                
                            $today = date('Ymdhis');
                            $name = $request->name;

                            //profile_pic and move img to folder 
                            if($profile_pic != ''){
                                $upload_path = base_path('uploads/scanner/profile_pic/');
                                $profile_pic_name = 'profile_pic'.rand().$today.''.$name.'.'.$profile_pic->getClientOriginalExtension();		

                                $profile_pic->move($upload_path,$profile_pic_name);
                            }
                            $ScannerProfile->profile_pic = isset($profile_pic_name)?$profile_pic_name:'';
                            $ScannerProfile->save();     
                            return response()->json([
                                'success' => true,
                                'data' => 'Scanner Profile data was generated.',
                            ]); 
                        }else{
                            return response()->json([
                                'success' => true,
                                'data' => 'The Employee ID is already in use.',
                            ]); 
                        }
                    }else{
                        return response()->json([
                            'success' => true,
                            'data' => 'The Phone Number is already in use.',
                        ]); 
                    }
                }else{
                    return response()->json([
                        'success' => true,
                        'data' => 'The Email Address is already in use.',
                    ]); 
                }           
        } catch (Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Oops! Something Went Wrong,  Please Try Again',
                ], 200);
        }
    }

    //add scnner profile password
    public function reset_scanner_password(Request $request)
    {
        try {
               $employee_id = $request->employee_id;
               $password = bcrypt($request->password);
               $confirm_password = bcrypt($request->confirm_password);
            if($request->password == $request->confirm_password){
                $ScannerProfile = ScannerProfile::where('id', $employee_id)->
                                    update(['password' => $password,
                                            'confirm_password' => $confirm_password,
                                            'updated_at' => date('Y-m-d H:i:s')]);   
                return response()->json([
                    'success' => true,
                    'data' => 'Password has been successfully changed.',
                ]); 
            }else{
                return response()->json([
                    'success' => true,
                    'data' => 'The password and the confirmed password do not match.',
                ]);
            }                                 
        } catch (Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Oops! Something Went Wrong,  Please Try Again',
                ], 200);
        }
    }

    //add scnner dashboard password
    public function scanner_dashboard_list(Request $request)
    {
        try {
               $role_id = $request->role_id;
            if(!empty($role_id)){
                $AddAnswerSheet = AddAnswerSheet::select('add_answer_sheets.id','add_answer_sheets.sheet_name','add_answer_sheets.class_id','classes.class_name','add_answer_sheets.exam_name','add_answer_sheets.subject','add_answer_sheets.academic_year_id','academic_years.year_name','add_answer_sheets.semister_id','semesters.semester_name','add_answer_sheets.division_id','divisions.division_name','add_answer_sheets.role_id','add_answer_sheets.scanned_file'
                                                    )->
                                                    join('classes','classes.id','add_answer_sheets.class_id')->
                                                    join('divisions','divisions.id','add_answer_sheets.division_id')->
                                                    join('academic_years','academic_years.id','add_answer_sheets.academic_year_id')->
                                                    join('semesters','semesters.id','add_answer_sheets.semister_id')->
                                                    where('add_answer_sheets.role_id', $role_id)->
                                                    orderby('add_answer_sheets.id','desc')->
                                                    groupBy('add_answer_sheets.sheet_name')->
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

    //Send Folder to Examiner
    public function send_to_examiner(Request $request)
    {
        try {
                $sheet_name=$request->sheet_name;
                $examiner_id=$request->examiner_id;
				$class_id=$request->class_id;
				$academic_year_id=$request->academic_year_id;
				$division_id=$request->division_id;
				$subject=$request->subject;
				
				
				//print_r($_REQUEST);
				//die;
                $user_id_data=AssignedSheet::where('sheet_name',$sheet_name)->where('examiner_id',$examiner_id)->first();
                if(!empty($user_id_data))
                {
                    return response()->json([
                        'success' => false,
                        'data' => 'Folder Already Sent to Examiner.',
                    ]);
                }
               else if (!empty($sheet_name)) {
                    $data=[
                        'examiner_id'=>$examiner_id,
                        'assigned_by_scanner'=>$request->assigned_by_scanner,
                        'sheet_path'=>"uploads/answer_sheet/$sheet_name",
                        'sheet_name'=>$sheet_name,
						'class_id'=>$class_id,
						'academic_year_id'=>$academic_year_id,
						'division_id'=>$division_id,
						'subject'=>$subject,
						
                    ];
                    if(AssignedSheet::create($data)){
                        return response()->json([
                            'success' => true,
                            'data' => 'Folder Sent to Examiner.',
                        ]);
                    }
                }
                else{
                return response()->json([
                    'success' => false,
                    'data' => 'Please provide the Sheet Name.',
                ]);
            }
                                             
        } catch (Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Oops! Something Went Wrong,  Please Try Again',
                ], 200);
        }
    }
}
