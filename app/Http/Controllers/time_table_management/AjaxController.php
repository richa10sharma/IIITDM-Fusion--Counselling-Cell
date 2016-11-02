<?php
namespace App\Http\Controllers\time_table_management;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Room_booking_request;
use App\Http\Controllers\Controller;
use Auth;
use DB;

class AjaxController extends Controller {
	public function change_tt(){
		$courses = '';
		if(!(empty($_GET['prog']) || empty($_GET['sem'])))
			$courses = DB::table('Course')->get()->where('sem', $_GET['sem'])->where('programme', $_GET['prog']);
		if(!empty($_GET['fcode'])){
			$courses = DB::table('Course_Taken_By')->get()->where('faculty_id', $_GET['fcode']);
		}

		$slots = DB::table('Classroom_Slots')->orderByRaw(DB::raw('FIELD (day, "Monday", "Tuesday", "WEDNESDAY", "THURSDAY", "FRIDAY", "SATURDAY", "SUNDAY")'))->orderBy('from_time')->get();

		return view('time_table_management/change_tt', compact('courses'), compact('slots'));
	}

	public function allot_room(){
        if(!Auth::user()->hasRole('admin')){
            return Redirect::to('time_table_management');
        }

        //admin function for updating(approving or rejecting) a particular request
        $approve = new Room_booking_request;
        //validation of data

        $room_id = $_GET["room_id"];
        $req_id = $_GET["req_id"];
        $dummy = "dummy_class";
        if($room_id == ''){
            //$approve->room_id = $dummy;
            //$approve->status = 2; 
            $approve::where('req_id', $req_id)
          ->update(['room_id' => $dummy,'status' => '2']);

        }
        else {
            # code...
            $approve::where('req_id', $req_id)
          ->update(['room_id' => $room_id,'status' => '1']);
            //$approve->room_id=room_id;
            //$approve->status = 1;
        }
        //$approve->save();
        return redirect()->back();
	}

	public function maintain(){
        if(!Auth::user()->hasRole('admin') && Auth::user()->user_type!="faculty"){
            return Redirect::to('time_table_management');
        }

		$repair = new Room_booking_request;
		$date1 = date('Y-m-d');
		$repair::where('date','<', $date1)->delete();
	}

    public function get_slots(){        
        $stime = $_GET['stime'];
        $etime = $_GET['etime'];
        $rdate = $_GET['date'];
        $timestamp = strtotime('rdate');
        $rday = date('l', $timestamp);

        $class_rooms = DB::table('Class_Rooms')->get();

        $booked_rooms_on_day = DB::table('Classroom_Slots')->get()->where('day', $rday);
        $booked_requests = DB::table('Room_Booking_Request')->get()->where('date', $rdate)->where('status', 1);

        $clash_rooms = array();

        foreach($booked_requests as $booked_request){
            $ftime = $booked_request->start_time;
            $to_time = $booked_request->end_time;

            $booked_room = $booked_request->room_id;

            if($ftime >= $stime && $ftime < $etime){
                $clash_rooms[] = $booked_room;
            }

            if($to_time > $stime && $to_time <= $etime){
                $clash_rooms[] = $booked_room;
            }

            if($ftime <= $stime && $to_time >= $etime){
                $clash_rooms[] = $booked_room;
            }

            if($ftime >= $stime && $to_time <= $etime){
                $clash_rooms[] = $booked_room;
            }
        }        

        foreach($booked_rooms_on_day as $booked_room_on_day){
            $ftime = $booked_room_on_day->from_time;
            $to_time = $booked_room_on_day->to_time;

            $booked_room = $booked_room_on_day->room_id;

            if($ftime >= $stime && $ftime < $etime){
                $clash_rooms[] = $booked_room;
            }

            if($to_time > $stime && $to_time <= $etime){
                $clash_rooms[] = $booked_room;
            }

            if($ftime <= $stime && $to_time >= $etime){
                $clash_rooms[] = $booked_room;
            }

            if($ftime >= $stime && $to_time <= $etime){
                $clash_rooms[] = $booked_room;
            }
        }

        $available_rooms = array();

        for($i=0; $i<count($class_rooms); $i++){
            $flag = 1;
            for($j=0; $j<count($clash_rooms); $j++){
                if($class_rooms[$i]->room_id == $clash_rooms[$j]){
                    $flag = 0;
                    break;
                }
            }

            if($flag==1){
                $available_rooms[] = $class_rooms[$i]->room_id;
            }
        }

        return $available_rooms;
    }
}

