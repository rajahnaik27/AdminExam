<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institute;
use App\Models\User;
use DB;

class InstituteController extends Controller
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

   public function add_institute(Request $request){
        try {
            $attributes = array(
                'institute_name' => $request->institute_name,
                'university' => $request->university,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $model = Institute::create($attributes)->id;
            $id = $model;

            if($files=$request->file('image')){  
                $request->validate([
                    'image' => 'required|mimes:png,jpeg,jpg|max:4096',
                ]);
                $name=$files->getClientOriginalName();  
                $files->move(base_path('uploads/institute'),$name);  
                // $data->path=$name;  
                $dt['logo'] = $name;
                Institute::where('id', $id)->update($dt);
            } 

            return response()->json([
                    'success' => true,
                    'data' => $id,
            ]);

        } catch (Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Oops! Something Went Wrong,  Please Try Again',
                ], 200);
        }
    }

    public function update_institute(Request $request){
        try {
          $id = $request->id;
		  
            $institute_name = $request->institute_name;
            $university = $request->university;
                
            $attributes = array(
                'institute_name' => $institute_name,
                'university' => $university,
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $model = Institute::where('id', $request->id)->update($attributes);
            
            if($files=$request->file('image')){  
                $request->validate([
                    'image' => 'required|mimes:png,jpeg,jpg|max:4096',
                ]);
                $name=$files->getClientOriginalName();  
                $files->move(base_path('uploads/institute'),$name);  
                // $data->path=$name;  
                $dt['logo'] = $name;
                Institute::where('id', $id)->update($dt);
            } 

            return response()->json([
                'success' => true,
                'data' => $id,
            ]);
        }catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Oops! Something Went Wrong,  Please Try Again',
            ], 200);
        }    
    }

    
    public function get_institute_list()
    {
       
        try {
            $instituteList = Institute::where('status', 1)->get();
            foreach ($instituteList as $key => $value) {
                if($value['logo'] != "" && $value['logo'] != NULL){
                    $url = url('/uploads/institute/'.$value['logo']);
                    $value['logo'] = $url;
                }
            }
            //Token created, return with success response and jwt token
            return response()->json([
                'success' => true,
                'data' => $instituteList,
            ]);
        } catch (Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Oops! Something Went Wrong,  Please Try Again',
                ], 200);
        }
    }


    public function get_institute(Request $request)
    {
        try {
            $examiner_id = $request->id;
            if($examiner_id != ""){
                $examiner = Institute::where('id', $examiner_id)->first();
                if($examiner && $examiner->logo != "" && $examiner->logo != NULl){
                    $examiner->logo = url('/uploads/institute/'.$examiner->logo);
                }
                //Token created, return with success response and jwt token
                return response()->json([
                    'success' => true,
                    'data' => $examiner,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Institute id is needed',
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Oops! Something Went Wrong,  Please Try Again',
                ], 200);
        }
    }
	
	public function delete_role(Request $request)
    {
        try {
			
            $user_id = $request->id;
			$role = $request->role;
			if($role != ""){
                $user = DB::table('users')->where('id', $user_id)->where('role', $role)->delete();
				
                return response()->json([
                    'success' => true,
                    'data' => $user,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Role id is needed',
                ], 200);
            }	
            
        } catch (Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Oops! Something Went Wrong,  Please Try Again',
                ], 200);
        }
    }
	
	
    public function delete_institute(Request $request)
    {
        try {
            $id = $request->id;
			
            if($id != ""){
				
				$institute = DB::table('institutes')->where('id', $id)->delete();
				
                return response()->json([
                    'success' => true,
                    'data' => $institute,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Institute id is needed',
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Oops! Something Went Wrong,  Please Try Again',
                ], 200);
        }
    }
}
