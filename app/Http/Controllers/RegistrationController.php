<?php

namespace App\Http\Controllers;

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
            'first_name' => "required|max:20|min:2|regex:/^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/",
            'last_name' => "required|max:10|min:2|regex:/^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/",
            'email' => "required|email|unique:account_credentials|regex:/^\+\d{11,14}$/",
            'password' => 'required|min:5',
            ],
            [
            'first_name.required' => 'First name is required',
            'first_name.max' => 'Maximum 20 characters allowed',
            'first_name.min' => 'Minimum 2 characters allowed',
            'first_name.regex' => 'Not a valid name',
            'last_name.required' => 'Last name is required',
            'last_name.max' => 'Maximum 10 characters allowed',
            'last_name.min' => 'Minimum 2 characters allowed',
            'last_name.regex' => 'Not a valid name',
            'email.required' => 'Email address is required',
            'email.unique' => 'Already registered with this email',
            'email.email' => 'Not a valid email address',
            'account_password.required' => 'Password is required',
            'account_password.min' => 'Password length is too short. Minimum 6 characters',
            ]);
        if ($validator->fails())
        {
            return response()->json(['code'=>'401','message'=>'Validation error.','data'=>$validator->errors()], 401);
        }

        $account = new Account();

    }
}
