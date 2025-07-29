<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use DB;

class AdminController extends Controller
{
    // protected $user;
 
    public function __construct()
    {
        // $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function get_examiner_list(Request $request)
    {
    	$role = $request->role;
    	try {
			$examinerList = User::where('role', $role)->get();
			foreach ($examinerList as $key => $value) {
				if($value['image_url'] != "" && $value['image_url'] != NULL){
					$url = url('/uploads/user/avatar/'.$value['image_url']);
					$value['image_url'] = $url;
				}
			}
			//Token created, return with success response and jwt token
			return response()->json([
				'success' => true,
				'data' => $examinerList,
			]);
		} catch (Exception $e) {
			return response()->json([
					'success' => false,
					'message' => 'Oops! Something Went Wrong,  Please Try Again',
				], 200);
		}
    }

    public function get_examiner(Request $request)
    {
    	try {
    		$examiner_id = $request->user_id;
    		if($examiner_id != ""){
				$examiner = User::where('id', $examiner_id)->first();
				if($examiner && $examiner->image_url != "" && $examiner->image_url != NULl){
					$examiner->image_url = url('/uploads/user/avatar/'.$examiner->image_url);
				}
				//Token created, return with success response and jwt token
				return response()->json([
					'success' => true,
					'data' => $examiner,
				]);
			} else {
				return response()->json([
					'success' => false,
					'message' => 'Examiner id is needed',
				], 200);
			}
		} catch (Exception $e) {
			return response()->json([
					'success' => false,
					'message' => 'Oops! Something Went Wrong,  Please Try Again',
				], 200);
		}
    }

    public function add_examiner(Request $request)
    {
    	try {
    		$uid_number = $request->uid_number;
    		$name = $request->name;
    		$email = $request->email;
    		$password = $request->password;
    		$date_of_birth = $request->date_of_birth;
    		$aadhar_number = $request->aadhar_number;
    		$mobile = $request->mobile;
    		$address = $request->address;
    		$role = $request->role;
    		$scanner_mid = $request->scanner_mid;
    		$institute_id = $request->institute_id;


    		if($email != "" && $password != "" && $name != "" && $mobile != ""){
				$attributes = array(
		            'name' => $name,
		            'email' => $email,
		            'password' => bcrypt($password),
		            'date_of_birth' => $date_of_birth,
		            'aadhar_number' => $aadhar_number,
		            'mobile' => $mobile,
		            'address' => $address,
		            'uid_number' => $uid_number,
		            'role' => $role,
		            'institute_id' => $institute_id,
		            'scanner_mid' => $scanner_mid,
		            'created_at' => date('Y-m-d H:i:s'),
		            'updated_at' => date('Y-m-d H:i:s'),
		        );
		        // $model = new User($attributes);
		        // $model->save();
		        $model = User::create($attributes)->id;
        		$id = $model;
		        if($files=$request->file('image')){  
		            $request->validate([
		                'image' => 'required|mimes:png,jpeg,jpg|max:4096',
		            ]);
		            $name=$files->getClientOriginalName();  
		            $files->move(base_path('uploads/user/avatar'),$name);  
		            // $data->path=$name;  
		            $dt['image_url'] = $name;
		            User::where('id', $id)->update($dt);
		        } 
				return response()->json([
					'success' => true,
					'data' => $id,
				]);
			} else {
				return response()->json([
					'success' => false,
					'message' => 'All fileds are required',
				], 200);
			}
		} catch (Exception $e) {
			return response()->json([
					'success' => false,
					'message' => 'Oops! Something Went Wrong,  Please Try Again',
				], 200);
		}
    }

    public function update_examiner(Request $request)
    {
    	try {
    		$id = $request->id;
    		$uid_number = $request->uid_number;
    		$name = $request->name;
    		$email = $request->email;
    		// $password = $request->password;
    		$date_of_birth = $request->date_of_birth;
    		$aadhar_number = $request->aadhar_number;
    		$mobile = $request->mobile;
    		$address = $request->address;
    		$scanner_mid = $request->scanner_mid;
    		$institute_id = $request->institute_id;
    		// $image_url = $request->image_url;
			
			$examiner = User::where('id', $id)->first();
    		$cur_email = $examiner->email;
			
			
    		if($email != "" && $name != ""){
				
				if($cur_email == $email){
					
    				$attributes = array(
			            'name' => $name,
			            'date_of_birth' => $date_of_birth,
			            'aadhar_number' => $aadhar_number,
			            'mobile' => $mobile,
			            'address' => $address,
			            'uid_number' => $uid_number,
			            'scanner_mid' => $scanner_mid,
			            'institute_id' => $institute_id,
			            'updated_at' => date('Y-m-d H:i:s'),
			        );
    			}else{
					
    				$attributes = array(
			            'name' => $name,
			            'email' => $email,
			            'date_of_birth' => $date_of_birth,
			            'aadhar_number' => $aadhar_number,
			            'mobile' => $mobile,
			            'address' => $address,
			            'uid_number' => $uid_number,
			            'scanner_mid' => $scanner_mid,
			            'institute_id' => $institute_id,
			            'updated_at' => date('Y-m-d H:i:s'),
			        );
    			}
				
		        // $model = new User($attributes);
		        // $model->save();
		        if(isset($request->password) && $request->password != ""){
		        	$attributes['password'] = bcrypt($request->password);
		        }
		        $model = User::where('id', $request->id)->update($attributes);
		        if($files=$request->file('image')){  
		            $request->validate([
		                'image' => 'required|mimes:png,jpeg,jpg|max:4096',
		            ]);
		            $name=$files->getClientOriginalName();  
		            $files->move(base_path('uploads/user/avatar'),$name);  
		            // $data->path=$name;  
		            $dt['image_url'] = $name;
		            User::where('id', $id)->update($dt);
		        } 
				return response()->json([
					'success' => true,
					'data' => $id,
				]);
			} else {
				return response()->json([
					'success' => false,
					'message' => 'All fileds are required',
				], 200);
			}
		} catch (Exception $e) {
			return response()->json([
					'success' => false,
					'message' => 'Oops! Something Went Wrong,  Please Try Again',
				], 200);
		}
    }

	//add student profile data
    public function add_student(Request $request)
    {
        try {
                $get_email = User::select('email')->where('email',$request->email)->orderBy('id', 'DESC')->first();
                $email = isset($get_email->email)?$get_email->email:'';
                if($email != $request->email){
                    $get_mobile = User::select('mobile')->where('mobile',$request->mobile)->orderBy('id', 'DESC')->first();
                    $mobile = isset($get_mobile->mobile)?$get_mobile->mobile:'';
                    if($mobile != $request->mobile){
							$get_aadhar_number = User::select('aadhar_number')->where('aadhar_number',$request->aadhar_number)->orderBy('id', 'DESC')->first();
                    		$aadhar_number = isset($get_aadhar_number->aadhar_number)?$get_aadhar_number->aadhar_number:'';
							if($aadhar_number != $request->aadhar_number){
								$User = new User();               
								$User->uid_number = $request->uid_number;
								$User->name = $request->name;
								$User->email = $request->email;
								$User->password = bcrypt($request->password);
								$User->date_of_birth = date('Y-m-d', strtotime($request->date_of_birth));
								$User->aadhar_number = $request->aadhar_number;
								$User->mobile = $request->mobile;
								$User->address = $request->address;
								$User->role = $request->role;
								$User->scanner_mid = $request->scanner_mid;
								$User->institute_id = $request->institute_id;
								$User->division_id = $request->division_id;
								$User->class_id = $request->class_id;
								$User->academic_id = $request->academic_id;
								$profile_pic = $request->image;
								$User->created_at = date('Y-m-d H:i:s');
								$User->updated_at = date('Y-m-d H:i:s');                
								$today = date('Ymdhis');
								$name = $request->name;
								
								//profile_pic and move img to folder 
								if($profile_pic != ''){
									$upload_path = base_path('uploads/student/profile_pic/');
									$profile_pic_name = 'profile_pic'.rand().$today.''.$name.'.'.$profile_pic->getClientOriginalExtension();		

									$profile_pic->move($upload_path,$profile_pic_name);
								}
								$User->image_url = isset($profile_pic_name)?$profile_pic_name:'';
								$User->save();     
								return response()->json([
									'success' => true,
									'data' => 'User data was generated.',
								]);
						}else{
							return response()->json([
								'success' => true,
								'data' => 'The Adhar Number is already in use.',
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
                        'data' => 'The email address is already in use.',
                    ]); 
                }           
        } catch (Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Oops! Something Went Wrong,  Please Try Again',
                ], 200);
        }
    }

	//update student profile data
    public function update_student(Request $request)
    {
        try {
				$profile_pic = isset($request->image)?$request->image:'';               
				$today = date('Ymdhis');
				$name = isset($request->name)?$request->name:'';
				$student_id = isset($request->id)?$request->id:'';
				
				//profile_pic and move img to folder 
				if($profile_pic != ''){
					$upload_path = base_path('uploads/student/profile_pic/');
					$profile_pic_name = 'profile_pic'.rand().$today.''.$name.'.'.$profile_pic->getClientOriginalExtension();		

					$profile_pic->move($upload_path,$profile_pic_name);
				}
				$profile_pic_name = isset($profile_pic_name)?$profile_pic_name:'';
				$get_email = User::select('email')->where('email',$request->email)->orderBy('id', 'DESC')->first();
				$email = isset($get_email->email)?$get_email->email:'';
				$User = new User(); 
				if(!empty($student_id)){
					if($email == $request->email){					
						$User = User::where('id', $student_id)->
											update(['uid_number' => $request->uid_number,
													'name' => $request->name,
													'password' => bcrypt($request->password),
													'date_of_birth' => date('Y-m-d', strtotime($request->date_of_birth)),
													'aadhar_number' => $request->aadhar_number,
													'mobile' => $request->mobile,
													'address' => $request->address,
													'role' => $request->role,
													'scanner_mid' => $request->scanner_mid,
													'institute_id' => $request->institute_id,
													'division_id' => $request->division_id,
													'class_id' => $request->class_id,
													'academic_id' => $request->academic_id,
													'image_url' => $profile_pic_name,
													'updated_at' => date('Y-m-d H:i:s')]);   
						return response()->json([
							'success' => true,
							'data' => 'User data has been successfully changed.',
						]);
							
					}else{
						$User = User::where('id', $student_id)->
											update(['uid_number' => $request->uid_number,
													'name' => $request->name,
													'email' => $request->email,
													'password' => bcrypt($request->password),
													'date_of_birth' => date('Y-m-d', strtotime($request->date_of_birth)),
													'aadhar_number' => $request->aadhar_number,
													'mobile' => $request->mobile,
													'address' => $request->address,
													'role' => $request->role,
													'scanner_mid' => $request->scanner_mid,
													'institute_id' => $request->institute_id,
													'division_id' => $request->division_id,
													'class_id' => $request->class_id,
													'academic_id' => $request->academic_id,
													'image_url' => $profile_pic_name,
													'updated_at' => date('Y-m-d H:i:s')]);  
						return response()->json([
							'success' => true,
							'data' => 'User data has been successfully changed.',
						]); 
					}   
				}else{
					return response()->json([
						'success' => true,
						'data' => 'Please provide student id.',
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