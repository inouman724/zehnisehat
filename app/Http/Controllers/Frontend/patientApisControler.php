<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\User;
use App\patientAppointment;

class patientApisControler extends Controller
{
    // this function needs to be uncommented if the middleware needs to be used here.
    // public function __construct()
    // {
    //     // $this->middleware('CheckIsPatient');
    // }
    // above function needs to be uncommented if the middleware needs to be used here.
    // Get Patient Appointments Api starts here
    public function getPatientAppointments(Request $request){
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }  
        $user_exist = User::find($request->user_id);
        if($user_exist)
        {
            $user_appointments = patientAppointment::where('patient_appointments.patient_id', $request->user_id)
            ->join('users', 'patient_appointments.patient_id', '=', 'users.id')
            ->join('therapist_details', 'patient_appointments.therapist_id', '=', 'therapist_details.therapist_id')
            ->select('users.full_name','therapist_details.therapist_fee','patient_appointments.checkup_day_time',
            'patient_appointments.follow_up_date','patient_appointments.status',
            'patient_appointments.created_at')
            ->get();
            $count = count($user_appointments);
            if($count>0)
            {
                return response()->json([
                    'status' => 200,
                    'message' => 'Data Found',
                    'data' => $user_appointments,
                ]);
            }
            else
            {
                return response()->json([
                    'status' => 400,
                    'message' => 'Data Not Found',
                ]);
            }
        }
        else
        {
            return response()->json([
                'status' => 400,
                'message' => 'Data Not Found',
            ]);
        }
    }
    // Get Patient Appointments Api ends here
    //-----------------------------------------------------------------------------------------//
}
