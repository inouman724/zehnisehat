<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\User;
use App\therapistDetails;
use App\therapist_education;
use App\therapist_work_experience;
use App\therapist_locations;
use App\category;
use DB;
use App\patientAppointment;


class adminApisController extends Controller
{
    
    public function adminAddTherapistWorkInfoData(Request $request){
        $therapist_id = $request->therapist_id;
        $therapistWorkInfo = $request->work_info;
        //dd($therapistEducationInfo);
        $deletedRows = therapist_work_experience::where('therapist_id', $therapist_id)->delete();
        $work_counter = count($therapistWorkInfo);
        //dd($education_counter);

        for($i=0;  $i<$work_counter; $i++){
                                
            $therapist_work_details = new therapist_work_experience;
            $therapist_work_details->therapist_id = $therapist_id;
            $therapist_work_details->organization_name = $therapistWorkInfo[$i]['organization_name'];
            $therapist_work_details->designation = $therapistWorkInfo[$i]['designation'];
            $therapist_work_details->tenure = $therapistWorkInfo[$i]['tenure'];
            $therapist_work_details->save();
        }
       
            if($therapist_work_details){
                return response()->json([
                    'status' => true,
                    'messge' => 'User Work Updated Successfully',
                ]);
            }
            else{
                return response()->json([
                    'status' => false,
                    'messge' => 'Something Went Wrong',
                ]);
            }
        
    }
    public function adminAddTherapistEducationInfoData(Request $request){
        $therapist_id = $request->therapist_id;
        $therapistEducationInfo = $request->education_info;
        //dd($therapistEducationInfo);
        $deletedRows = therapist_education::where('therapist_id', $therapist_id)->delete();
        $education_counter = count($therapistEducationInfo);
        //dd($education_counter);

        for($i=0;  $i<$education_counter; $i++){
                                
            $therapist_education_details = new therapist_education;
            $therapist_education_details->therapist_id = $therapist_id;
            $therapist_education_details->university_name = $therapistEducationInfo[$i]['university_name'];
            $therapist_education_details->degree_program = $therapistEducationInfo[$i]['degree_program'];
            $therapist_education_details->tenure = $therapistEducationInfo[$i]['tenure'];
            $therapist_education_details->save();
        }
       
            if($therapist_education_details){
                return response()->json([
                    'status' => true,
                    'messge' => 'User Education Updated Successfully',
                ]);
            }
            else{
                return response()->json([
                    'status' => false,
                    'messge' => 'Something Went Wrong',
                ]);
            }
        
    }
    public function adminAddTherapistBioInfoData(Request $request){
        $therapistBioInfo = $request->bio_info;
        
            $updateDetails = [
                'category_id' => $therapistBioInfo['category_id'],
                'about_therapist' => $therapistBioInfo['about_therapist'],
                'therapist_fee' => $therapistBioInfo['therapist_fee'],
               
            ];
            $new_user = therapistDetails::where('therapist_id',$therapistBioInfo['therapist_id'])->update($updateDetails);
            if($new_user){
                return response()->json([
                    'status' => true,
                    'messge' => 'User Details Updated Successfully',
                ]);
            }
            else{
                return response()->json([
                    'status' => false,
                    'messge' => 'Something Went Wrong',
                ]);
            }
            
        
    }
    public function adminAddTherapistGeneralInfoData(Request $request){
        $therapistGeneralInfo = $request->general_info;
        
            $updateDetails = [
                'phone_number' => $therapistGeneralInfo['phone'],
                'dob' => $therapistGeneralInfo['dob'],
                'gender' => $therapistGeneralInfo['gender'],
                'blood_group' => $therapistGeneralInfo['blood_group'],
               
            ];
            $new_user = User::where('id',$therapistGeneralInfo['id'])->update($updateDetails);
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
    public function adminAddTherapistLoginInfoData(Request $request){
        $therapistLoginInfo = $request->login_info;
        
            $updateDetails = [
                'full_name' => $therapistLoginInfo['full_name'],
                'email' => $therapistLoginInfo['email'],
                'password' => bcrypt($therapistLoginInfo['password']),
               
            ];
            $new_user = User::where('id',$therapistLoginInfo['id'])->update($updateDetails);
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

    public function getTherapistWorkData(Request $request){
        $therapist_id = $request->therapist_id;

        $single_work = therapist_work_experience::where('therapist_id', $therapist_id)->get();
        //dd($single_education);
        if($single_work){
            $work_data = array();
            $work_data['work_info'] = $single_work;
            return response()->json([
                'status' => true,
                'messge' => 'Data found',
                'data' => $work_data,
            ]);
        }
        else{
            return response()->json([
                'status' => false,
                'messge' => 'No data found',
            ]);
        }


    }
    public function getTherapistEducationData(Request $request){
        $therapist_id = $request->therapist_id;

        $single_education = therapist_education::where('therapist_id', $therapist_id)->get();
        //dd($single_education);
        if($single_education){
            $education_data = array();
            $education_data['education_info'] = $single_education;
            return response()->json([
                'status' => true,
                'messge' => 'Data found',
                'data' => $education_data,
            ]);
        }
        else{
            return response()->json([
                'status' => false,
                'messge' => 'No data found',
            ]);
        }


    }
    public function getTherapistBioData(Request $request){
        $therapist_id = $request->therapist_id;

        $single_therapist = therapistDetails::where('therapist_id','like',$therapist_id) -> first();
        if($single_therapist){
            $therapist_data = array();
            $therapist_data['bio_info'] = $single_therapist;
            return response()->json([
                'status' => true,
                'messge' => 'Data found',
                'data' => $therapist_data,
            ]);
        }
        else{
            return response()->json([
                'status' => false,
                'messge' => 'No data found',
            ]);
        }


    }
    public function getTherapistGeneralData(Request $request){
        $therapist_id = $request->therapist_id;

        $single_therapist = User::where('id','like',$therapist_id) -> first();
        if($single_therapist){
            $therapist_data = array();
            $therapist_data['general_info'] = $single_therapist;
            return response()->json([
                'status' => true,
                'messge' => 'Data found',
                'data' => $therapist_data,
            ]);
        }
        else{
            return response()->json([
                'status' => false,
                'messge' => 'No data found',
            ]);
        }


    }
    public function getTherapistDataByIdData(Request $request){
        $therapist_id = $request->therapist_id;

        $single_therapist = User::where('id','like',$therapist_id) -> first();
        if($single_therapist){
            $therapist_data = array();
            $therapist_data['login_info'] = $single_therapist;
            return response()->json([
                'status' => true,
                'messge' => 'Data found',
                'data' => $therapist_data,
            ]);
        }
        else{
            return response()->json([
                'status' => false,
                'messge' => 'No data found',
            ]);
        }


    }
    
    

    public function addNewSpecialityData(Request $request){
        $add_speciality_title = $request->category_name;
        $add_speciality_description = $request->category_description;
        $category = new category;
        $duplicate_entry = category::where('title','like',$add_speciality_title) -> first();
        if($duplicate_entry){
            return response()->json([
                'status' => false,
                'messge' => 'Title Already Registered',
            ]);
        }
        else{
            $category->published_by = '1';
            $category->title = $add_speciality_title;
            $category->description = $add_speciality_description;
            $category->picture = 'category.png';
            if($category->save()){
                return response()->json([
                    'status' => true,
                    'messge' => 'Speciality Added Successfully',
                ]);
            }
            else{
                return response()->json([
                    'status' => false,
                    'messge' => 'Something Went Wrong',
                ]);

            }

        }
        
    }
    public function radminChangeSpecialityData(Request $request){
        $change_speciality_data = $request->speciality_data;
        
        $input_id = $change_speciality_data[0]['speciality_id'];
        $input_name = $change_speciality_data[0]['speciality_name'];
        $category = new category;
        $duplicate_entry = category::where('title','like',$input_name) -> first();
        if($duplicate_entry){
            return response()->json([
                'status' => false,
                'messge' => 'Title Already Registered',
            ]);
        }
        else{
            $category = category::where('id',$input_id)->update(['title'=>$input_name]);
            if($category){
                return response()->json([
                    'status' => true,
                    'messge' => 'Speciality Updated Successfully',
                ]);
            }
            else{
                return response()->json([
                    'status' => false,
                    'messge' => 'Something Went Wrong',
                ]);

            }
        }
        
    }
    public function registerNewTherapistData(Request $request){
        
        $all_data = $request->therapist_data;
        //dd($all_data);
        if($all_data[0]['therapist_login_info']){

            // User-Table
            $therapist_full_name = $all_data[0]['therapist_login_info']['full_name'];
            $therapist_email = $all_data[0]['therapist_login_info']['email'];
            $therapist_pasword = $all_data[0]['therapist_login_info']['password'];
            $therapist_blood = $all_data[0]['therapist_general_info']['blood'];
            $therapist_dob = $all_data[0]['therapist_general_info']['dob'];
            $therapist_gender = $all_data[0]['therapist_general_info']['gender'];
            $therapist_phone = $all_data[0]['therapist_general_info']['phone'];

            $user = new User;
            $user->full_name = $therapist_full_name;
            $user->email = $therapist_email;
            $user->password = bcrypt($therapist_pasword);
            $user->is_email_verified = false;
            $user->is_verified_by_admin = false;
            $user->is_admin = false;
            $user->is_patient = false;
            $user->is_therapist = true;
            $user->phone_number = $therapist_phone;
            $user->dob = $therapist_dob;
            $user->gender = $therapist_gender;
            $user->blood_group = $therapist_blood;
            $user->_token = str_random(16);

            $duplicate_entry = User::where('email','like',$therapist_email) -> first();
            //dd($duplicate_entry);
            if($duplicate_entry){
                
                return response()->json([
                    'status' => false,
                    'messge' => 'Email Already Registered',
                ]);
            }
            else{

                if($user->save())
                {

                    $last_id = $user->id;
                    $therapist_about = $all_data[0]['therapist_bio'];
                    $therapist_fee = $all_data[0]['therapist_fee'];
                    $therapist_category = $all_data[0]['therapist_category'];

                    $therapist_details = new therapistDetails;
                    $therapist_details->therapist_id = $last_id;
                    $therapist_details->about_therapist = $therapist_about;
                    $therapist_details->therapist_fee = $therapist_fee;
                    $therapist_details->category_id = $therapist_category;
                    $therapist_details->license_id = '123456789';
                    $therapist_details->country = 'Pakistan';
                    $therapist_details->lat_long = '123,123';

                    // $duplicate_details = User::where('therapist_id', $therapist_details->therapist_id);
                    if($therapist_details->save()){
                        
                        $therapist_education_array = $all_data[0]['therapist_education_info'];

                        $education_counter = count($therapist_education_array);
                        if($education_counter>0 && $education_counter==1){

                            //dd($therapist_education_array[0]['degree']);
                            $therapist_education_details = new therapist_education;
                            $therapist_education_details->therapist_id = $last_id;
                            $therapist_education_details->university_name = $therapist_education_array[0]['college'];
                            $therapist_education_details->degree_program = $therapist_education_array[0]['degree'];
                            $therapist_education_details->tenure = $therapist_education_array[0]['completion'];
                            $therapist_education_details->save();

                        }
                        elseif($education_counter>1){

                            for($i=0;  $i<$education_counter; $i++){
                                
                                $therapist_education_details = new therapist_education;
                                $therapist_education_details->therapist_id = $last_id;
                                $therapist_education_details->university_name = $therapist_education_array[$i]['college'];
                                $therapist_education_details->degree_program = $therapist_education_array[$i]['degree'];
                                $therapist_education_details->tenure = $therapist_education_array[$i]['completion'];
                                $therapist_education_details->save();
                            }
                        }
                        //dd($education_counter);

                        $put_therapist_work_info = $this->putTherapistWorkInfo($all_data[0]['therapist_work_info'], $last_id);
                        $put_therapist_clinic_info = $this->putTherapistClinicInfo($all_data[0]['therapist_clinic_info'], $last_id);
                        
                        return response()->json([
                            'status' => true,
                            'message' => 'User registered successfully.',
                        ]);
                    }
                    else{
                        return response()->json([
                            'status' => true,
                            'messge' => 'Something Went Wrong with user details',
                        ]);
                    }

                    
                }
                else{
                    return response()->json([
                        'status' => true,
                        'messge' => 'Something Went Wrong with User',
                    ]);
                }
            }
            //dd($therapist_full_name.'-'.$therapist_email.'-'.$therapist_pasword);
        }
        else{
            return response()->json([
                'status' => 400,
                'message' => 'Data Not Found',
            ]);
        }
    }



    public function putTherapistClinicInfo($therapistClinicInfo, $therapist){
        

            //dd($therapist_education_array[0]['degree']);
            $therapist_clinic_details = new therapist_locations;
            $therapist_clinic_details->therapist_id = $therapist;
            $therapist_clinic_details->clinic_name = $therapistClinicInfo['name'];
            $therapist_clinic_details->address = $therapistClinicInfo['address'];
            $therapist_clinic_details->save();
        

        return true;
    }
    public function putTherapistWorkInfo($therapistWorkInfo, $therapist){
        $work_counter = count($therapistWorkInfo);
        if($work_counter>0 && $work_counter==1){

            //dd($therapist_education_array[0]['degree']);
            $therapist_work_details = new therapist_work_experience;
            $therapist_work_details->therapist_id = $therapist;
            $therapist_work_details->organization_name = $therapistWorkInfo[0]['organization'];
            $therapist_work_details->tenure = $therapistWorkInfo[0]['date_from'].', '.$therapistWorkInfo[0]['date_to'];
            $therapist_work_details->save();

        }
        elseif($work_counter>1){

            for($i=0;  $i<$work_counter; $i++){
                
                $therapist_work_details = new therapist_work_experience;
                $therapist_work_details->therapist_id = $therapist;
                $therapist_work_details->organization_name = $therapistWorkInfo[$i]['organization'];
                $therapist_work_details->tenure = $therapistWorkInfo[$i]['date_from'].', '.$therapistWorkInfo[$i]['date_to'];
    
                $therapist_work_details->save();
            }
        }

        return true;

    }
    public function getAdminProfileData(Request $request)
    {   
        $sql  ="
        SELECT * FROM users
        WHERE users.is_admin = true
        ";
        $admin_profile= DB::select($sql);

        //return $sp_category;
        return response()->json([
            'status' => 200,
            'message' => 'Data Found',
            'data' => $admin_profile,
        ]);
    }
    public function getAllReviewsData(Request $request){
        $sql  ="
        SELECT therapist_reviews.id, therapist_reviews.created_at, therapist_reviews.feedback, users.full_name as therapist_name, u2.full_name as patient_name
        FROM therapist_reviews 

        LEFT JOIN users 
        ON  therapist_reviews.therapist_id  = users.id
        LEFT JOIN users u2
        ON  therapist_reviews.patient_id  = u2.id

        ORDER BY therapist_reviews.id
        ";
        $reviews= DB::select($sql);

        //return $sp_category;
        return response()->json([
            'status' => 200,
            'message' => 'Data Found',
            'data' => $reviews,
        ]);
    }
    public function getAllPatientsData(Request $request){
        $sql  ="
        SELECT users.id, users.postal_adress, users.full_name, users.phone_number, users.gender, users.created_at
        FROM users 

        WHERE users.is_patient = true
        ORDER BY users.id
        ";
        $patients= DB::select($sql);

        //return $sp_category;
        return response()->json([
            'status' => 200,
            'message' => 'Data Found',
            'data' => $patients,
        ]);
    }
    public function getAllTherapistsData(Request $request){
        $sql  ="
        SELECT users.id, users.full_name, therapist_details.therapist_fee, categories.title as speciality, users.created_at
        FROM users 
        LEFT JOIN therapist_details 
        ON  users.id  = therapist_details.therapist_id
        LEFT JOIN categories 
        ON  therapist_details.category_id  = categories.id

        WHERE users.is_therapist = true
        ORDER BY users.id DESC
        ";
        $therapists= DB::select($sql);

        //return $sp_category;
        return response()->json([
            'status' => 200,
            'message' => 'Data Found',
            'data' => $therapists,
        ]);
    }
    public function getAllSpecialititesData(Request $request){

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

    public function getAllAppointmentsData(Request $request){
        $sql  ="
        SELECT patient_appointments.id, patient_appointments.comments, users.full_name, u2.full_name as therapist_name, categories.title as therapist_speciality, patient_appointments.created_at
        FROM patient_appointments 
        LEFT JOIN users 
        ON patient_appointments.patient_id =  users.id
        LEFT JOIN users u2
        ON patient_appointments.therapist_id =  u2.id
        LEFT JOIN therapist_details
        ON patient_appointments.therapist_id =  therapist_details.therapist_id
        LEFT JOIN categories
        ON therapist_details.category_id =  categories.id
        
        ORDER BY patient_appointments.id DESC
        ";
        $sp_category = DB::select($sql);

        //return $sp_category;
        return response()->json([
            'status' => 200,
            'message' => 'Data Found',
            'data' => $sp_category,
        ]);
    }
    public function getAdminDashboardData(Request $request){
        // $id = $request->user()->id;
        // $user_exist = User::find($id);
        // if($user_exist)
        // {
            //dd('in');
            // $admin_data = User::where('id', '=', $id)->pluck('full_name');
            $admin_data = User::where('id', '=', 1)->pluck('full_name');
            $total_therapists = User::where('is_therapist', '=', '1')->get();
            $total_patients = User::where('is_patient', '=', '1')->get();
            $patient_appointments = patientAppointment::get();
            
            $count_therapists = count($total_therapists);
            $count_patients = count($total_patients);
            $count_appointments = count($patient_appointments);
            $count = count($admin_data);
            if($count>0)
            {
                $admin_new_data['admin_name'] = $admin_data[0];
                $admin_new_data['total_therapists'] = $count_therapists;
                $admin_new_data['total_patients'] = $count_patients;
                $admin_new_data['total_appointments'] = $count_appointments;
                return response()->json([
                    'status' => 200,
                    'message' => 'Data Found',
                    'data' => $admin_new_data,
                    // 'total_therapists' => $count_therapists,
                    // 'total_patients' => $count_patients,
                ]);
            }
            else
            {
                return response()->json([
                    'status' => 400,
                    'message' => 'Data Not Found',
                ]);
            }
        // }
        // else
        // {
        //     return response()->json([
        //         'status' => 400,
        //         'message' => 'Data Not Found',
        //     ]);
        // }
    }
   
    //-----------------------------------------------------------------------------------------//
}
