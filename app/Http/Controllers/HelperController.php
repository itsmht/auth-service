<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelperController extends Controller
{
    public function account_name(Request $req)
{
    $accountIds = $req->input('account_ids', []); // expect array like [1, 2, 3]

    if (empty($accountIds)) {
        return response()->json([
            'code' => 400,
            'message' => 'No account IDs provided.',
            'data' => null
        ], 400);
    }

    $accounts = \App\Models\Account::whereIn('account_id', $accountIds)
        ->select('account_id', 'name')
        ->get();

    if ($accounts->isEmpty()) {
        return response()->json([
            'code' => 404,
            'message' => 'No accounts found.',
            'data' => null
        ], 404);
    }

    return response()->json([
        'code' => 200,
        'message' => 'Accounts found.',
        'data' => $accounts
    ], 200);
}
function validateToken(Request $req)
{
    $token = $req->header('Authorization');
    try
    {
        $token_db = \App\Models\Token::where('token', $token)->where('status', 'N')->first();
        if (!$token_db)
        {
            return response()->json(['code'=>'401','message'=>'Invalid token.','data'=>null], 401);
        }
        $account = \App\Models\Account::where('account_id', $token_db->account_id)->first();
        return response()->json([
            'code' => 200,
            'message' => 'Token is valid.',
            'data' => [
                'account_id' => $account->account_id,
            ]
        ], 200);
    }
    catch (\Exception $e)
    {
        return response()->json(['code'=>'500','message'=>'Server error.','data'=>null], 500);
    }
}
function instructors()
{
    $instructors = \App\Models\Account::where('role', 'instructor')
        ->select('account_id', 'name')
        ->get();

    return response()->json([
        'code' => 200,
        'message' => 'Instructors retrieved successfully.',
        'data' => $instructors
    ], 200);
}

}
