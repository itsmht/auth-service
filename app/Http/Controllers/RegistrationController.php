<?php

namespace App\Http\Controllers;
use App\Models\Account;
use App\Models\Credential;
use App\Models\Token;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;
use Datetime;
use Illuminate\Support\Str;
class RegistrationController extends Controller
{
    public function register(Request $req)
    {
        $validator = Validator::make($req->all(),
            [
            'name' => "required|max:30|min:2|regex:/^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/",
            'email' => "required|email|unique:account_credentials",
            'password' => 'required|min:5',
            "conf_password"=>"required|same:password",
            ],
            [
            'name.required' => 'First name is required',
            'name.max' => 'Maximum 20 characters allowed',
            'name.min' => 'Minimum 2 characters allowed',
            'name.regex' => 'Not a valid name',
            'email.required' => 'Email address is required',
            'email.unique' => 'Already registered with this email',
            'email.email' => 'Not a valid email address',
            'password.required' => 'Password is required',
            'password.min' => 'Password length is too short. Minimum 6 characters',
            'conf_password.required' => 'Confirm password is required',
            'conf_password.same' => 'Password and confirm password do not match',
            ]);
        if ($validator->fails())
        {
            return response()->json(['code'=>'401','message'=>'Validation error.','data'=>$validator->errors()], 401);
        }

        $oneID = Str::random(6);
        $ip = $req->ip();
        $token = Str::random(16);
        $deviceID = $req->deviceID;
        $deviceName = $req->deviceName;
        try
        {   
            //Account Creation
            $account = new Account();
            $account->name = $req->name;
            $account->oneID = $oneID;
            $account->role = "non-subscribed";
            $account->home_ip = $ip;
            $account->home_deviceID = $deviceID;
            $account->home_device_name = $deviceName;
            $account->profession = $req->profession;
            $account->phone = $req->phone;
            $account->education = $req->education;
            $account->address = $req->address;
            $account->status = "A";
            $account->dob = $req->dob;
            $account->save();
            //Account Credentials
            $account_credentials = new Credential();
            $account_credentials->email = $req->email;
            $account_credentials->password = bcrypt($req->password);
            $account_credentials->account_id = $account->account_id;
            $account_credentials->save();
            //Token generation
            $account_token = new Token();
            $account_token->account_id = $account->account_id;
            $account_token->token = $token;
            $account_token->status = "N";
            $account_token->expired_at = null;
            //$account_token->expired_at = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $account_token->save();
            //Tracking
            $account_tracking = new Track();
            $account_tracking->account_id = $account->account_id;
            $account_tracking->ip_address = $ip;
            $account_tracking->deviceID = $deviceID;
            $account_tracking->device_name = $deviceName;
            $account_tracking->status = "A";
            $account_tracking->last_login = date('Y-m-d H:i:s');
            $account_tracking->last_logout = null;
            $account_tracking->save();
            //Response
            return response()->json(['code'=>'200','message'=>'Registration Successful','data'=>$token], 200);
        }
        catch (\Exception $e)
        {
            return response()->json(['code'=>'500','message'=>'Internal server error.','data'=>$e->getMessage()], 500);
        }
    }
    function updateAccount(Request $req)
    {
        $token = $req->header('Authorization');
        $token_verify = Token::where('token', $token)->first();
        if (!$token_verify) {
            return response()->json(['code'=>'401','message'=>'Unauthorized access.'], 401);
        }
        
        try
        {
            $account = Account::where('account_id', $token_verify->account_id)->first();
            $account->name = $req->name;
            $account->gender = $req->gender;
            $account->media = $req->media;
            $account->dob = $req->dob;
            if ($req->hasFile('image_path')) 
            {
                $file = $req->file('image_path');
                $fileName = $account->oneID . "-" . "-" . time() . "." . $file->getClientOriginalExtension();
                $file->move(public_path('profile_images'), $fileName);
                $banner->image_path = url("profile_images/$fileName");
            }
            $account->save();
            //Response
            return response()->json(['code'=>'200','message'=>'Account updated successfully.','data'=>$account], 200);
        }
        catch (\Exception $e)
        {
            return response()->json(['code'=>'500','message'=>'Internal server error.','data'=>$e->getMessage()], 500);
        }
    }
    function genreSelection(Request $req)
    {
        $token = $req->header('Authorization');
        $token_verify = Token::where('token', $token)->first();
        if (!$token_verify) {
            return response()->json(['code'=>'401','message'=>'Unauthorized access.'], 401);
        }
        
        try
        {
            foreach ($req->genre_name as $genre_name) {
                $genre = new Genre();
                $genre->account_id = $token_verify->account_id;
                $genre->genre_name = $genre_name;
                $genre->save();
            }
            //Response
            return response()->json(['code'=>'200','message'=>'Genre selected successfully.','data'=>$account], 200);
        }
        catch (\Exception $e)
        {
            return response()->json(['code'=>'500','message'=>'Internal server error.','data'=>$e->getMessage()], 500);
        }
    }
}
