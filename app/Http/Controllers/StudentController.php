<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
//use App\Models\Student;
use App\Models\User;

class StudentController extends Controller
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

    //fetch Particular student profile data
    public function fetch_student_profile(Request $request)
    {
        try {
                $student_id = isset($request->id)?$request->id:'';
                if(!empty($student_id)){
                    $fetch_student_profile = User::select('users.id','users.name','users.email','users.date_of_birth','users.aadhar_number','users.mobile','users.address',
                                                             'users.uid_number','users.role','users.institute_id','institutes.institute_name','users.division_id','divisions.division_name','users.class_id','classes.class_name','users.academic_id','academic_years.year_name','users.image_url')->
                                                      join('classes','classes.id','users.class_id')->
                                                      join('divisions','divisions.id','users.division_id')->
                                                      join('academic_years','academic_years.id','users.academic_id')->
                                                      join('institutes','institutes.id','users.institute_id')->
                                                      where('users.id',$student_id)->
                                                      where('users.role',4)->
                                                      orderBy('users.id', 'DESC')->
                                                      get();
                    if(count($fetch_student_profile)>0){ 
                        foreach ($fetch_student_profile as $key => $value){                         
                            $images = explode (",", isset($value['image_url']) ? $value['image_url'] : null);
                            $image_urls = str_replace( array( '\'','"',',','"','[', ']' ), '', $images); 
                            $image_url = isset($image_urls[0]) ? $image_urls[0] :null;
                            $url = url('/');
                            $value['image_url'] = $url."/uploads/student/profile_pic/".$image_url;                                          
                        }                         
                        return response()->json([
                            'success' => true,
                            'data' => $fetch_student_profile
                        ]);
                    }else{
                        $fetch_student_profile = [];                        
                        return response()->json([
                            'success' => true,
                            'data' => $fetch_student_profile
                        ]);
                    }  
                }else{
                    $fetch_student_profile = User::select('users.id','users.name','users.email','users.date_of_birth','users.aadhar_number','users.mobile','users.address',
                                                             'users.uid_number','users.role','users.institute_id','institutes.institute_name','users.division_id','divisions.division_name','users.class_id','classes.class_name','users.academic_id','academic_years.year_name','users.image_url')->
                                                      join('classes','classes.id','users.class_id')->
                                                      join('divisions','divisions.id','users.division_id')->
                                                      join('academic_years','academic_years.id','users.academic_id')->
                                                      join('institutes','institutes.id','users.institute_id')->
                                                      where('users.role',4)->
                                                      orderBy('users.id', 'DESC')->
                                                      get();
                    if(count($fetch_student_profile)>0){ 
                        foreach ($fetch_student_profile as $key => $value){                         
                            $images = explode (",", isset($value['image_url']) ? $value['image_url'] : null);
                            $image_urls = str_replace( array( '\'','"',',','"','[', ']' ), '', $images); 
                            $image_url = isset($image_urls[0]) ? $image_urls[0] :null;
                            $url = url('/');
                            $value['image_url'] = $url."/uploads/student/profile_pic/".$image_url;                                          
                        }                         
                        return response()->json([
                            'success' => true,
                            'data' => $fetch_student_profile
                        ]);
                    }else{
                        $fetch_student_profile = [];                        
                        return response()->json([
                            'success' => true,
                            'data' => $fetch_student_profile
                        ]);
                    }
                }
                                         
        } catch (Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Oops! Something Went Wrong,  Please Try Again',
                ], 200);
        }
    }

    //add student profile data
    public function reset_student_password(Request $request)
    {
        try {
               $student_id = $request->student_id;
               $password = bcrypt($request->password);
               $confirm_password = bcrypt($request->confirm_password);
            if($request->password == $request->confirm_password){
                $Student = User::where('id', $student_id)->
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
}