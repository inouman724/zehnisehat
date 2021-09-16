<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\User;
use App\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use HasApiTokens;
// use Authenticatable;

class registerationController extends Controller
// class registerationController extends //Authenticatable
{
    //
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            // 'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        // dd($request->all());
        $user = new User;
        if($request->role == 'patient')
        {
            $user->is_patient = true;
            $user->is_therapist = false;
            $user->is_admin = false;
        }
        elseif($request->role == 'therapist')
        {
            $user->is_therapist = true;
            $user->is_patient = false;
            $user->is_admin = false;
        }
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->is_email_verified = false;
        $user->is_verified_by_admin = false;
        if($user->save())
        {
            return response()->json([
                'status' => true,
                'message' => 'User registered successfully.',
                // 'token' => $token,
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'something went wrong',
            ]);
        }

        // $success['token'] =  $user->createToken('ZehniSehatUser')->accessToken;
        // $success['full_name'] =  $user->full_name;
        // return $this->sendResponse($success, 'User register successfully.');
        // $token =  $user->createToken('ZehniSehatUser')->accessToken;
        
    }
   
    /**
     * Login api
     *
    //  * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user();
            if($user->is_admin == true)
            {
                $role = 'admin';
            }
            elseif($user->is_therapist == true)
            {
                $role = 'therapist';
            }
            elseif($user->is_patient == true)
            {
                $role = 'patient';
            }
            // $success['token'] =  $user->createToken('ZehniSehatUser')-> accessToken; 
            $token =  $user->createToken('ZehniSehatUser')-> accessToken;
            $user_role = $role; 
            // $success['full_name'] =  $user->full_name;
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'id' => $user->id,
                'token' => $token,
                'role' => $user_role,
            ]);
   
            // return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    //     public function home()
    //     {
    //         dd('You are active');
    //     }
}
