<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Room;
use App\Models\Location;
use App\Models\Sos;
use App\Models\Feedback;
use DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        //get list of not approved customers
        $location = Location::groupBy('city')->get();
        foreach ($location as $key => $value) {
            $user_count = Location::where('city', $value['city'])->distinct('user_id')->orderBy('id','desc')->count();
            $value['user_count'] = $user_count;
        }
        $presentUser = Attendance::where('attendance_type', 1)->where('check_in',1)->distinct('user_id')->count();
        $infortePresentUser = Attendance::where('attendance_type', 2)->where('check_in',1)->where('check_out',0)->distinct('user_id')->count();
        $inforteAttendedUser = Attendance::where('attendance_type', 2)->where('check_in',1)->distinct('user_id')->count();
        $unconPresentUser = Attendance::where('attendance_type', 3)->where('check_in',1)->where('check_out',0)->distinct('user_id')->count();
        $unconAttendedUser = Attendance::where('attendance_type', 3)->where('check_in',1)->distinct('user_id')->count();
        //get all rommms
        $rooms = Room::get();
        foreach ($rooms as $key => $value) {
            $room_id = $value['id'];
            $value['present_users'] = Attendance::where('attendance_type', 4)->where('room_no', $room_id)->where('check_in',1)->where('check_out',0)->distinct('user_id')->count();
            $value['attended_users'] = Attendance::where('attendance_type', 4)->where('room_no', $room_id)->where('check_in',1)->distinct('user_id')->count();
        }
        //day feedback count
        $dayonecount = Feedback::where('dayid', 1)->count();
        $daytwocount = Feedback::where('dayid', 2)->count();
        $daythreecount = Feedback::where('dayid', 3)->count();
        return view('dashboard')
        ->with('presentUser', $presentUser)
        ->with('infortePresentUser', $infortePresentUser)
        ->with('inforteAttendedUser', $inforteAttendedUser)
        ->with('unconPresentUser', $unconPresentUser)
        ->with('unconAttendedUser', $unconAttendedUser)
        ->with('dayonecount', $dayonecount)
        ->with('daytwocount', $daytwocount)
        ->with('daythreecount', $daythreecount)
        ->with('locations', $location)
        ->with('rooms', $rooms);
    }

    public function attendance_add(){
        $rooms = Room::all();
        return view('present_users.add')->with('rooms', $rooms);
    }

    public function attendance_save(Request $request){
        $mobile = $request->mobile;
        $name = $request->name;
        $type = $request->attendance_type;
        $room_no = 0;
        if(isset($request->room_id)){
            $room_no = $request->room_id;
        }
        $user = User::where('mobile', $mobile)->first();
        if($user != NULL && $user != ""){
            if($type == 1){
                // previous check checkin 1 and checkout 0
                $attendanceNotCheckoutList = Attendance::where('attendance_type', '!=', 1)->where('user_id', $user->id)->where('check_in',1)->where('check_out', 0)->get();
                foreach ($attendanceNotCheckoutList as $key => $value) {
                    Attendance::where('id', $value['id'])->update(['check_out' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
                }
                $attributes = array(
                    'user_id' => $user->id,
                    'attendance_type' => 1,
                    'room_no' => $room_no,
                    'check_in' => 1,
                    'check_out' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                );
                Attendance::create($attributes);
                
            } else if($type == 2){
                //get attendance against user for hotel and add checckout 1
                $row = Attendance::where('user_id', $user->id)->where('attendance_type', 1)->first();
                $id = $row->id;
                $attributes = array(
                    'check_out' => 1,
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                Attendance::where('id', $id)->update($attributes);
            } else if($type == 3){
                $attendanceNotCheckoutList = Attendance::where('attendance_type', '!=', 1)->where('user_id', $user->id)->where('check_in',1)->where('check_out', 0)->get();
                foreach ($attendanceNotCheckoutList as $key => $value) {
                    Attendance::where('id', $value['id'])->update(['check_out' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
                }
                $attributes = array(
                    'user_id' => $user->id,
                    'attendance_type' => 2,
                    'room_no' => $room_no,
                    'check_in' => 1,
                    'check_out' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                );
                Attendance::create($attributes);
            } else if($type == 4){
                //get attendance against user for hotel and add checckout 1
                $row = Attendance::where('user_id', $user->id)->where('attendance_type', 2)->first();
                $id = $row->id;
                $attributes = array(
                    'check_out' => 1,
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                Attendance::where('id', $id)->update($attributes);
            } else if($type == 5){
                $attendanceNotCheckoutList = Attendance::where('attendance_type', '!=', 1)->where('user_id', $user->id)->where('check_in',1)->where('check_out', 0)->get();
                foreach ($attendanceNotCheckoutList as $key => $value) {
                    Attendance::where('id', $value['id'])->update(['check_out' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
                }
                $attributes = array(
                    'user_id' => $user->id,
                    'attendance_type' => 3,
                    'room_no' => $room_no,
                    'check_in' => 1,
                    'check_out' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                );
                Attendance::create($attributes);
            } else if($type == 6){
                //get attendance against user for hotel and add checckout 1
                $row = Attendance::where('user_id', $user->id)->where('attendance_type', 3)->first();
                $id = $row->id;
                $attributes = array(
                    'check_out' => 1,
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                Attendance::where('id', $id)->update($attributes);
            } else if($type == 7){
                $attendanceNotCheckoutList = Attendance::where('attendance_type', '!=', 1)->where('user_id', $user->id)->where('check_in',1)->where('check_out', 0)->get();
                foreach ($attendanceNotCheckoutList as $key => $value) {
                    Attendance::where('id', $value['id'])->update(['check_out' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
                }
                $attributes = array(
                    'user_id' => $user->id,
                    'attendance_type' => 4,
                    'room_no' => $room_no,
                    'check_in' => 1,
                    'check_out' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                );
                Attendance::create($attributes);
            } else if($type == 8){
                //get attendance against user for hotel and add checckout 1
                $row = Attendance::where('user_id', $user->id)->where('attendance_type', 4)->where('check_out', 0)->first();
                $id = $row->id;
                $attributes = array(
                    'check_out' => 1,
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                Attendance::where('id', $id)->update($attributes);
            }
        }
        // return redirect->route('admin_present_users');
        return redirect('/admin/present_users');
    }

    public function get_by_mobile(Request $request){
        //check with user table then check with our user table and add entry
        $custdata = DB::select("SELECT * from user where mobile = '".$request->mobile."' ");
        if(count($custdata) > 0){
            $user = User::where('mobile', $request->mobile)->first();
            if($user != NULL && $user != ""){
                $data['status'] = 'success';
                echo json_encode($data);
                die();
            } else {
                $custnm = $custdata[0]->name;
                $custmb = $custdata[0]->mobile;
                $user_array = array(
                    'name' => $custnm,
                    'email' => $custmb,
                    'mobile' => $custmb,
                    'password' => bcrypt('123'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                User::create($user_array);
                $data['status'] = 'success';
                echo json_encode($data);
                die();
            }
        }
        $data['status'] = 'error';
            echo json_encode($data);
        die();
    }

    public function present_users(){
        return view('present_users.list');    
    }

    public function present_users_list(Request $request){
        $start = $request->start;
        $limit = $request->length; 
        $search = $request->search['value'];
        $attendanceList = Attendance:: leftJoin('users', 'users.id', '=', 'attendances.user_id');
        if($search != NULL && $search != ""){
            $where = "(users.name LIKE '%$search%')";
            $attendanceList->whereRaw($where);   
        }
        $attendanceList = $attendanceList->groupBy('attendances.user_id')->get(['users.*','attendances.user_id']);
        $users = Attendance:: leftJoin('users', 'users.id', '=', 'attendances.user_id');
        if($search != NULL && $search != ""){
            $where = "(users.name LIKE '%$search%')";
            $users->whereRaw($where);   
        }
        $users = $users->groupBy('attendances.user_id')->offset($start)->limit($limit)->get(['users.*','attendances.user_id']);
        foreach ($users as $key => $value) {
            $hotel_checkin = "-";
            $hotel_checkout = "-";
            $uncon_checkin = "-";
            $uncon_checkout = "-";
            $breather_checkin = "-";
            $breather_checkout = "-";
            $inforte_checkin = "-";
            $inforte_checkout = "-";
            $hotelcheckin = Attendance::where('user_id', $value['user_id'])->where('attendance_type', 1)->orderBy('id', 'desc')->first();
            if($hotelcheckin != NULL && $hotelcheckin != ""){
                if($hotelcheckin->check_in == 1){
                    $hotel_checkin = date('d/m/Y h:i A', strtotime($hotelcheckin->created_at));
                }
                if($hotelcheckin->check_out == 1){
                    $hotel_checkout = date('d/m/Y h:i A', strtotime($hotelcheckin->updated_at));    
                }
            }
            $infortecheckin = Attendance::where('user_id', $value['user_id'])->where('attendance_type', 2)->orderBy('id', 'desc')->first();
            if($infortecheckin != NULL && $infortecheckin != ""){
                if($infortecheckin->check_in == 1){
                    $inforte_checkin = date('d/m/Y h:i A', strtotime($infortecheckin->created_at));
                }
                if($infortecheckin->check_out == 1){
                    $inforte_checkout = date('d/m/Y h:i A', strtotime($infortecheckin->updated_at));    
                }
            }
            $unconcheckin = Attendance::where('user_id', $value['user_id'])->where('attendance_type', 3)->orderBy('id', 'desc')->first();
            if($unconcheckin != NULL && $unconcheckin != ""){
                if($unconcheckin->check_in == 1){
                    $uncon_checkin = date('d/m/Y h:i A', strtotime($unconcheckin->created_at));
                }
                if($unconcheckin->check_out == 1){
                    $uncon_checkout = date('d/m/Y h:i A', strtotime($unconcheckin->updated_at));    
                }
            }
            $breathercheckin = Attendance::where('user_id', $value['user_id'])->where('attendance_type', 4)->orderBy('id', 'desc')->first();
            if($breathercheckin != NULL && $breathercheckin != ""){
                if($breathercheckin->check_in == 1){
                    $breather_checkin = date('d/m/Y h:i A', strtotime($breathercheckin->created_at));
                }
                if($breathercheckin->check_out == 1){
                    $breather_checkout = date('d/m/Y h:i A', strtotime($breathercheckin->updated_at));    
                }
            }
            $value['hotel_check_in'] = $hotel_checkin;
            $value['inforte_check_in'] = $inforte_checkin;
            $value['inforte_check_out'] = $inforte_checkout;
            $value['uncon_check_in'] = $uncon_checkin;
            $value['uncon_check_out'] = $uncon_checkout;
            $value['breather_check_in'] = $breather_checkin;
            $value['breather_check_out'] = $breather_checkout;
            $value['hotel_check_out'] = $hotel_checkout;
        }
        $data['data'] = $users;
        $data['recordsTotal'] = count($attendanceList);
        $data['recordsFiltered'] = count($attendanceList);
        echo json_encode($data);
        die();  
    }

    public function present_users_attendance(Request $request){
        $user_id = $request->user_id;
        return view('present_users.attendance')->with('user_id', $user_id);    
    }

    public function present_users_attendance_list(Request $request){
        $start = $request->start;
        $limit = $request->length; 
        $search = $request->search['value'];
        $user_id = $request->user_id;
        $attendanceList = Attendance:: leftJoin('users', 'users.id', '=', 'attendances.user_id')->leftJoin('event_types', 'event_types.id', '=', 'attendances.attendance_type')->leftJoin('rooms', 'rooms.id', '=', 'attendances.room_no');
        if($search != NULL && $search != ""){
            $where = "(users.name LIKE '%$search%')";
            $attendanceList->whereRaw($where);   
        }
        $attendanceList = $attendanceList->where('attendances.user_id', $user_id)->get(['attendances.*','event_types.type','rooms.room_name']);
        $users = Attendance:: leftJoin('users', 'users.id', '=', 'attendances.user_id')->leftJoin('event_types', 'event_types.id', '=', 'attendances.attendance_type')->leftJoin('rooms', 'rooms.id', '=', 'attendances.room_no');
        if($search != NULL && $search != ""){
            $where = "(users.name LIKE '%$search%')";
            $users->whereRaw($where);   
        }
        $users = $users->where('attendances.user_id', $user_id)->offset($start)->limit($limit)->get(['attendances.*','event_types.type','rooms.room_name']);
        foreach ($users as $key => $value) {
            $value['check_in_time'] = date('Y-m-d H:i:s', strtotime($value['created_at']));
            if($value['check_out'] == 1){
                $value['check_out_time'] = date('Y-m-d H:i:s', strtotime($value['updated_at']));
            } else {
                $value['check_out_time'] = '-';
            }
        }
        $data['data'] = $users;
        $data['recordsTotal'] = count($attendanceList);
        $data['recordsFiltered'] = count($attendanceList);
        echo json_encode($data);
        die(); 
    }

    public function user_tracking(Request $request){
        $user_id = $request->user_id;
        $locationList = Location::where('user_id', $user_id)->orderBy('id','desc')->get();
        return view('present_users.user_track')->with('locations', $locationList);
    }

    public function sos(){
        $sosList = Sos::get();
        return view('present_users.sos')->with('sosList', $sosList);
    }

    public function users(){
        return view('users.list');    
    }

    public function users_list(Request $request){
        $start = $request->start;
        $limit = $request->length; 
        $search = $request->search['value'];
        $attendanceList = User::where('role', 1);
        if($search != NULL && $search != ""){
            $where = "(users.name LIKE '%$search%')";
            $attendanceList->whereRaw($where);   
        }
        $attendanceList = $attendanceList->get();
        $users = User::where('role', 1);
        if($search != NULL && $search != ""){
            $where = "(users.name LIKE '%$search%')";
            $users->whereRaw($where);   
        }
        $users = $users->offset($start)->limit($limit)->get();
        $data['data'] = $users;
        $data['recordsTotal'] = count($attendanceList);
        $data['recordsFiltered'] = count($attendanceList);
        echo json_encode($data);
        die();  
    }

    public function users_add(){
        return view('users.add');
    }

    public function users_edit(Request $request){
        $users = User::where('id', $request->id)->where('role', 1)->first();
        if($users == NULL || $users == "" || $users == false){
            abort(404);
        }
        return view('users.edit')->with('users', $users);
    }

    public function users_save(Request $request){
        $mobile = $request->mobile;
        $users = User::where('mobile', $mobile)->first();
        if($users == NULL || $users == "" || $users == false){
            //add new entry
            $password = '123';
            $attributes = array(
                'name' => $request->name,
                'mobile' => $request->mobile,
                'password' => bcrypt($password),
                'role' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            $model = new User($attributes);
            $model->save();
            return redirect('/admin/users');
        } else {
            //update role
            $sql = User::findOrFail($users->id);
            $sql->update(['role' => 1]);
            return redirect('/admin/users');
        }
    }

    public function users_update(Request $request){
        // $password = '123';
        $attributes = array(
            'name' => $request->name,
            'mobile' => $request->mobile,
            // 'password' => bcrypt($password),
            'role' => 1,
            'updated_at' => date('Y-m-d H:i:s')
        );
        User::where('id', $request->id)->update($attributes);
        return redirect('/admin/users');
    }

    public function delete(Request $request){
        try {
            $sql = User::findOrFail($request->id);
            $sql->update(['role' => 0]);
            return response()->json([
                'status' => 'Success',
                'message' => 'Record updated Successfully!'
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }

    public function make_volunteer(Request $request){
        try {
            $sql = User::findOrFail($request->id);
            $sql->update(['role' => 1]);
            return response()->json([
                'status' => 'Success',
                'message' => 'Record updated Successfully!'
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }
}
