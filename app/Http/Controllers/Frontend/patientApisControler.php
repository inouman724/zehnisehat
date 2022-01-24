<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\User;
use App\patientAppointment;
use DB;

class patientApisControler extends Controller
{
  
    // public function __construct()
    // {
    //     // $this->middleware('CheckIsPatient');
    // }
    public function updatePatientPassword(Request $request){

            
        $id = $request->user()->id;
        $patient_details = User::find($id);
        if($patient_details)
        {
            $patient_password = $request->patientPassword;
                
                $updateDetails = [
                    'password' => bcrypt($patient_password),
                
                ];
                $new_user = User::where('id',$id)->update($updateDetails);
                if($new_user){
                    return response()->json([
                        'status' => true,
                        'messge' => 'user Updated Successfully',
                    ]);
                }
                else{
                    return response()->json([
                        'status' => false,
                        'messge' => 'Something Went Wrong',
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
    public function updatePatientInfoData(Request $request){
            
        $id = $request->user()->id;
        $patient_details = User::find($id);
        if($patient_details)
        {

                $patient_info = $request->patientInfo;
                
                $updateDetails = [
                    'full_name' => $patient_info['full_name'],
                    'dob' => $patient_info['dob'],
                    'gender' => $patient_info['gender'],
                    'blood_group' => $patient_info['blood_group'],
                    'phone_number' => $patient_info['phone_number'],
                    'postal_adress' => $patient_info['postal_adress'],
                
                ];
                $new_user = User::where('id',$id)->update($updateDetails);
                if($new_user){
                    return response()->json([
                        'status' => true,
                        'messge' => 'user Updated Successfully',
                    ]);
                }
                else{
                    return response()->json([
                        'status' => false,
                        'messge' => 'Something Went Wrong',
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
    public function getPatientAppointmentData(Request $request){
        $id = $request->user()->id;
        $patient_details = User::find($id);
        if($patient_details)
        {
            $sql  ="
            SELECT patient_appointments.checkup_day_time, patient_appointments.status, users.full_name,categories.title as therapist_speciality, patient_appointments.created_at
            FROM patient_appointments 
            LEFT JOIN users 
            ON patient_appointments.therapist_id =  users.id
            LEFT JOIN therapist_details
            ON patient_appointments.therapist_id =  therapist_details.therapist_id
            LEFT JOIN categories
            ON therapist_details.category_id =  categories.id
            WHERE patient_appointments.patient_id = $id
            ORDER BY patient_appointments.id DESC
            ";
            $patient_appointments = DB::select($sql);
            if($patient_appointments){
                return response()->json([
                    'status' => 200,
                    'message' => 'Data  Found',
                    'data' => $patient_appointments
                ]);
            }
            else{

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
    public function getPatientData(Request $request){
        $id = $request->user()->id;
        $patient_details = User::find($id);
        if($patient_details)
        {
            return response()->json([
                'status' => 200,
                'message' => 'Data Found',
                'data' => $patient_details,
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




    // Get Patient Appointments Api starts here
    public function getPatientDataOLD(Request $request){ 
        
        $id = $request->user()->id;
        $user_exist = User::find($id);
        if($user_exist)
        {
            $user_appointments = patientAppointment::where('patient_appointments.patient_id', $id)
            ->join('users', 'patient_appointments.patient_id', '=', 'users.id')
            ->join('therapist_details', 'patient_appointments.therapist_id', '=', 'therapist_details.therapist_id')
            ->select('users.full_name','users.image','therapist_details.therapist_fee',
            'patient_appointments.checkup_day_time',
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
