<?php

namespace App\Http\Controllers;
use App\Mail\SendOtpMail;
use App\Models\Account;
use App\Models\Credential;
use App\Models\VerificationOTP;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;
use Datetime;
use Illuminate\Support\Str;

class VerificationController extends Controller
{
    function verifyEmail(Request $req)
    {
        $validator = Validator::make($req->all(),
            [
                'email' => "required|email|unique:account_credentials",
            ],
            [
                'email.required' => 'Email address is required',
                'email.unique' => 'Email address already registered',
                'email.email' => 'Not a valid email address',
            ]);
        if ($validator->fails())
        {
            return response()->json(['code'=>'401','message'=>'Validation error.','data'=>$validator->errors()], 401);
        }
        //$token = Str::random(16);
        $otp = random_int(100000, 999999);
        //$otp = "00000"; // For testing purpose only
        $email = $req->email;
        try
            {
                // Check if the email already exists with status = 'V'
                $existing = VerificationOTP::where('email', $email)
                                        ->where('status', 'V')
                                        ->first();

                if ($existing) {
                    return response()->json([
                        'code' => '409',
                        'message' => 'This email is already verified and user registration was successful.',
                        'data' => null
                    ], 409); // Conflict with existing verified email
                }

                // Otherwise, create a new OTP entry
                $otp_db = new VerificationOTP();
                $otp_db->email = $email;
                $otp_db->otp = $otp;
                $otp_db->status = "N";
                $otp_db->purpose = "V";
                $otp_db->save();

                // --- ADD THIS SECTION ---
                // Now, send the email using the Mailable we created
                // Pass the generated $otp to the Mailable's constructor
                Mail::to($email)->send(new SendOtpMail($otp));
                // -------------------------

                return response()->json([
                    'code' => '200',
                    'message' => 'Verification OTP sent to email.',
                    'data' => null
                ], 200);
            }
            catch (\Exception $e)
            {
                return response()->json([
                    'code' => '500',
                    'message' => 'Internal server error.',
                    'data' => $e->getMessage()
                ], 500);
            }

    }
    function verifyOTP(Request $req)
    {
        $validator = Validator::make($req->all(),
            [
                'email' => "required|email",
                'otp' => "required|numeric",
            ],
            [
                'email.required' => 'Email address is required',
                'email.email' => 'Not a valid email address',
                'otp.required' => 'OTP is required',
                'otp.numeric' => 'OTP should be numeric',
            ]);
        if ($validator->fails())
        {
            return response()->json(['code'=>'401','message'=>'Validation error.','data'=>$validator->errors()], 401);
        }
        $email = $req->email;
        $otp = $req->otp;
        try
        {
            $otp_db = VerificationOTP::where('email', $email)->where('otp', $otp)->first();
            if ($otp_db)
            {
                if ($otp_db->status == "N")
                {
                    $otp_db->status = "V";
                    $otp_db->save();
                    return response()->json(['code'=>'200','message'=>'OTP verified successfully.','data'=>null], 200);
                }
                else
                {
                    return response()->json(['code'=>'400','message'=>'OTP already used or expired.','data'=>null], 400);
                }
            }
            else
            {
                return response()->json(['code'=>'400','message'=>'Invalid OTP.','data'=>null], 400);
            }
        }
        catch (\Exception $e)
        {
            return response()->json(['code'=>'500','message'=>'Internal server error.','data'=>$e], 500);
        }
    }
}
