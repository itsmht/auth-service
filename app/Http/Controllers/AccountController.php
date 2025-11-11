<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    function myProfile(Request $req)
    {
        $token = $req->header('Authorization');
        try
        {
            $token_db = \App\Models\Token::where('token', $token)->where('status', 'N')->first();
            if (!$token_db)
            {
                return response()->json(['code'=>'401','message'=>'Invalid token.','data'=>null], 401);
            }
            $account = \App\Models\Account::where('account_id', $token_db->account_id)
                                            ->select('account_id', 'name', 'oneID', 'role', 'image_path', 'profession', 'phone', 'education', 'address', 'dob', 'created_at')
                                            ->first();
            if (!$account)
            {
                return response()->json(['code'=>'401','message'=>'Account not found.','data'=>null], 401);
            }
            return response()->json(['code'=>'200','message'=>'Profile fetched successfully.','data'=>$account], 200);
        }
        catch (\Exception $e)
        {
            return response()->json(['code'=>'500','message'=>'Server error.','data'=>null], 500);
        }
    }
}
