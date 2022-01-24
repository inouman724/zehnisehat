<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\User;
use App\patientAppointment;
use DB;

class therapistApisControler extends Controller
{
    public function getTherapistPatientData(Request $request){
        $id = $request->user()->id;
        $therapist_details = User::find($id);
        if($therapist_details)
        {
            $sql_patients = "SELECT DISTINCT users.id, users.postal_adress,users.phone_number,users.gender,users.full_name as patient_name
            FROM patient_appointments a
            LEFT JOIN users
            ON users.id = a.patient_id
            WHERE therapist_id = '$id'";
            $patients = DB::select($sql_patients);
            if($patients){
                return response()->json([
                    'status' => 200,
                    'message' => 'Data Found',
                    'data' => $patients,
                ]);

            }
            else{
                return response()->json([
                    'status' => 400,
                    'message' => 'Data Not Found',
                ]);
            }

        }
        else{
            return response()->json([
                'status' => 400,
                'message' => 'Data Not Found',
            ]);
        }
    }
    public function getTherapistDashboardData(Request $request){
        $id = $request->user()->id;
        $therapist_details = User::find($id);
        if($therapist_details)
        {
            $total_patients = patientAppointment::where('therapist_id', $id)->get();
            $total_patients = count($total_patients);
            
            $today = date('Y-m-d');
            $sql = "SELECT b.*, users.full_name as patient_name
            FROM patient_appointments b
            LEFT JOIN users
            ON users.id = b.patient_id
            WHERE DATE(checkup_day_time) ='$today'  AND  therapist_id = '$id'";
            $today_patient = DB::select($sql);
            $total_today_patient = count($today_patient);

            $sql_upcoming = "SELECT a.*, users.full_name as patient_name
            FROM patient_appointments a
            LEFT JOIN users
            ON users.id = a.patient_id
            WHERE DATE(checkup_day_time) >'$today'  AND  therapist_id = '$id'";
            $upcoming_appointments = DB::select($sql_upcoming);
            
            
            return response()->json([
                'status' => 400,
                'message' => 'Data Found',
                'total_patients' => $total_patients,
                'total_today_patients' => $total_today_patient,
                'total_appointments' => $total_patients,
                'today_appointments' => $today_patient,
                'upcoming_appointments' => $upcoming_appointments,
            ]);


        }
        else{
            return response()->json([
                'status' => 400,
                'message' => 'Data Not Found',
            ]);
        }
    }
    public function getTherapistData(Request $request){
        $id = $request->user()->id;
        $therapist_details = User::find($id);
        if($therapist_details)
        {
            $sql  ="
            SELECT categories.title
            FROM therapist_details
            LEFT JOIN categories
            ON categories.id = therapist_details.category_id
            WHERE therapist_details.therapist_id = $id
            ORDER BY therapist_details.id DESC
            ";
            $therapist_category = DB::select($sql);
            $therapist_details->specialization = $therapist_category[0]->title;
            return response()->json([
                'status' => 200,
                'message' => 'Data Found',
                'data' => $therapist_details,
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
}