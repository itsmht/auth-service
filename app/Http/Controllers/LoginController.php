<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Credential;
use App\Models\VerificationOTP;
use App\Models\Track;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;
use Datetime;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    function login(Request $req)
    {
        $validator = Validator::make($req->all(),
            [
                'email' => "required|email",
                'password' => "required",
            ],
            [
                'email.required' => 'Email address is required',
                'email.email' => 'Not a valid email address',
                'password.required' => 'Password is required',
            ]);
        if ($validator->fails())
        {
            return response()->json(['code'=>'401','message'=>'Validation error.','data'=>$validator->errors()], 401);
        }
        $email = $req->email;
        $password = $req->password;
        try
        {
            $credential = Credential::where('email', $email)->first();
            if (!$credential)
            {
                return response()->json(['code'=>'401','message'=>'Email not found.','data'=>null], 401);
            }
            if (!password_verify($password, $credential->password))
            {
                return response()->json(['code'=>'401','message'=>'Password do not match.','data'=>null], 401);
            }
            $account = Account::where('account_id', $credential->account_id)->first();
            if (!$account)
            {
                return response()->json(['code'=>'401','message'=>'Account not found.','data'=>null], 401);
            }
            // Generate token
            $token = Str::random(16);
            // Save token in database
            $token_db = new Token();
            $token_db->account_id = $account->account_id;
            $token_db->token = $token;
            $token_db->status = "N";
            $token_db->save();

            // Save login track
            $track = new Track();
            $track->account_id = $account->account_id;
            $track->ip_address = $req->ip();
            $track->deviceID = $req->header('User-Agent');
            $track->device_name = $req->header('User-Agent');
            $track->last_login = new Datetime();
            $track->save();
            // Send response
            return response()->json(['code'=>'200','message'=>'Login successful.','data'=>['token'=>$token]], 200);
        }
        catch (\Exception $e)
        {
            return response()->json(['code'=>'500','message'=>'Internal server error.','data'=>$e], 500);
        }
    }
    function logout(Request $req)
    {
        $validator = Validator::make($req->all(),
            [
                'token' => "required",
            ],
            [
                'token.required' => 'Token is required',
            ]);
        if ($validator->fails())
        {
            return response()->json(['code'=>'401','message'=>'Validation error.','data'=>$validator->errors()], 401);
        }
        $token = $req->token;
        try
        {
            $token_db = Token::where('token', $token)->where('status', 'N')->first();
            if (!$token_db)
            {
                return response()->json(['code'=>'401','message'=>'Invalid token.','data'=>null], 401);
                if($token_db->status == "E")
                {
                    return response()->json(['code'=>'401','message'=>'Token already expired.','data'=>null], 401);
                }
            }
            $token_db->status = "E";
            $token_db->save();
            return response()->json(['code'=>'200','message'=>'Logout successful.','data'=>null], 200);
        }
        catch (\Exception $e)
        {
            return response()->json(['code'=>'500','message'=>'Internal server error.','data'=>$e], 500);
        }
    }
}
