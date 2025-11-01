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

}
