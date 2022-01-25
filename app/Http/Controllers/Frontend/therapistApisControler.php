<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\User;
use App\patientAppointment;
use App\therapistDetails;
use App\therapist_education;
use App\therapist_work_experience;
use DB;

class therapistApisControler extends Controller
{
    public function updateTherapistPasswordData(Request $request){
        $id = $request->user()->id;
        $therapist_details = User::find($id);
        if($therapist_details)
        {
            $therapist_password = $request->therapistPassword;
                
                $updateDetails = [
                    'password' => bcrypt($therapist_password),
                
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
    public function updateAllTherapistData(Request $request){
        $id = $request->user()->id;
        $therapist_details = User::find($id);
        if($therapist_details)
        {
            $all_data = $request->therapist_data;

            $therapist_general_info = $all_data['general_info'];
            $therapist_bio_info = $all_data['bio_info'];
            $therapist_education_info = $all_data['education_info'];
            $therapist_work_info = $all_data['work_info'];
            
            $put_general_info = $this->putTherapistGeneralInfo($therapist_general_info, $id);
            $put_bio_info = $this->putTherapistBioInfo($therapist_bio_info, $id);
            $put_education_info = $this->putTherapistEducationInfo($therapist_education_info, $id);
            $put_work_info = $this->putTherapistWorkInfo($therapist_work_info, $id);
            
            return response()->json([
                'status' => 400,
                'message' => 'Data Updated',
            ]);
        }
        else{
            return response()->json([
                'status' => 400,
                'message' => 'Data Not Found',
            ]);
        }

    }
    public function putTherapistWorkInfo($workInfo, $therapistID){
        //dd($generaInfo[0]['blood_group']);
        $deletedRows = therapist_work_experience::where('therapist_id', $therapistID)->delete();
        $work_counter = count($workInfo);
        //dd($educationInfo);
        for($i=0;  $i<$work_counter; $i++){
                                
            $therapist_work_details = new therapist_work_experience;
            $therapist_work_details->therapist_id = $therapistID;
            $therapist_work_details->organization_name = $workInfo[$i]['organization_name'];
            $therapist_work_details->designation = $workInfo[$i]['designation'];
            $therapist_work_details->tenure = $workInfo[$i]['tenure'];
            $therapist_work_details->save();
        }
        if($therapist_work_details){
            return true;
        }
        else{
            return false;
        }
    }
    public function putTherapistEducationInfo($educationInfo, $therapistID){
        //dd($generaInfo[0]['blood_group']);
        $deletedRows = therapist_education::where('therapist_id', $therapistID)->delete();
        $education_counter = count($educationInfo);
        //dd($educationInfo);
        for($i=0;  $i<$education_counter; $i++){
                                
            $therapist_education_details = new therapist_education;
            $therapist_education_details->therapist_id = $therapistID;
            $therapist_education_details->university_name = $educationInfo[$i]['university_name'];
            $therapist_education_details->degree_program = $educationInfo[$i]['degree_program'];
            $therapist_education_details->tenure = $educationInfo[$i]['tenure'];
            $therapist_education_details->save();
        }
        if($therapist_education_details){
            return true;
        }
        else{
            return false;
        }
    }
    public function putTherapistBioInfo($bioInfo, $therapistID){
        //dd($generaInfo[0]['blood_group']);
        $updateDetails = [
            'category_id' => $bioInfo[0]['category_id'],
            'about_therapist' => $bioInfo[0]['about_therapist'],
            'therapist_fee' => $bioInfo[0]['therapist_fee']
           
        ];
        $update_status = therapistDetails::where('therapist_id',$therapistID)->update($updateDetails);
        if($update_status){
            true;
        }
        else{
            false;
        }
    }
    public function putTherapistGeneralInfo($generaInfo, $therapistID){
        $updateDetails = [
            'blood_group' => $generaInfo[0]['blood_group'],
             'dob' => $generaInfo[0]['dob'],
             'full_name' => $generaInfo[0]['full_name'],
             'gender' => $generaInfo[0]['gender'],
             'phone_number' => $generaInfo[0]['phone_number']
           
        ];
        $update_status = User::where('id',$therapistID)->update($updateDetails);
        if($update_status){
            true;
           // dd('success');
        }
        else{
            false;
            //dd('fail');
        }
    }
    public function getTherapistAllSpecialititesData(Request $request){
        $id = $request->user()->id;
        $therapist_details = User::find($id);
        if($therapist_details)
        {
            $sql  ="SELECT *
            FROM categories 
            ORDER BY categories.id DESC
            ";
            $categoreis= DB::select($sql);

            //return $sp_category;
            return response()->json([
                'status' => 200,
                'message' => 'Data Found',
                'data' => $categoreis,
            ]);
        }
        else{
            return response()->json([
                'status' => 400,
                'message' => 'Data Not Found',
            ]);
        }
    }
    public function getTherapistGeneralDataForPortal(Request $request){
        $id = $request->user()->id;
        $therapist_details = User::find($id);
        if($therapist_details)
        {
            $therapist_all_data = array();
            $sql_general_info = "SELECT  users.email, users.full_name, users.phone_number, users.gender,users.blood_group, users.dob
            FROM users
            WHERE users.id = '$id' AND users.is_therapist=1";
            $therapist_general_info = DB::select($sql_general_info);

            $sql_bio_info = "SELECT  therapist_details.about_therapist, therapist_details.therapist_fee, therapist_details.category_id
            FROM therapist_details
            WHERE therapist_details.therapist_id = '$id'";
            $therapist_bio_info = DB::select($sql_bio_info);

            $sql_education_info = "SELECT  therapist_education.university_name, therapist_education.degree_program, therapist_education.tenure
            FROM therapist_education
            WHERE therapist_education.therapist_id = '$id'";
            $therapist_education_info = DB::select($sql_education_info);

            $sql_work_info = "SELECT  therapist_work_experience.organization_name, therapist_work_experience.designation, therapist_work_experience.tenure
            FROM therapist_work_experience
            WHERE therapist_work_experience.therapist_id = '$id'";
            $therapist_work_info = DB::select($sql_work_info);




            $therapist_all_data['general_info'] = $therapist_general_info;
            $therapist_all_data['bio_info'] = $therapist_bio_info;
            $therapist_all_data['education_info'] = $therapist_education_info;
            $therapist_all_data['work_info'] = $therapist_work_info;
            return response()->json([
                'status' => 400,
                'message' => 'Data Found',
                'data' => $therapist_all_data,
            ]);

        }
        else{
            return response()->json([
                'status' => 400,
                'message' => 'Data Not Found',
            ]);
        }
    }
    public function getTherapistReviewsData(Request $request){
        $id = $request->user()->id;
        $therapist_details = User::find($id);
        if($therapist_details)
        {
            $sql_reviews = "SELECT users.full_name,therapist_reviews.rating, therapist_reviews.feedback
            FROM therapist_reviews 
            LEFT JOIN users
            ON therapist_reviews.patient_id = users.id
            WHERE therapist_reviews.therapist_id = '$id'";
            $reviews = DB::select($sql_reviews);
            if($reviews){
         
                    return response()->json([
                        'status' => 200,
                        'message' => 'Data Found',
                        'data' => $reviews
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