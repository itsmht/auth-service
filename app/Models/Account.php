<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';
    protected $primaryKey = 'account_id';
    use HasFactory;

    function token()
    {
        return $this->hasMany('App\Models\Token', 'account_id', 'account_id');
    }
    function track()
    {
        return $this->hasMany('App\Models\Track', 'account_id', 'account_id');
    }
    function otp()
    {
        return $this->hasMany('App\Models\OTP', 'account_id', 'account_id');
    }
    function credential()
    {
        return $this->hasMany('App\Models\Review', 'account_id', 'account_id');
    }
    function rating()
    {
        return $this->hasMany('App\Models\Credential', 'account_id', 'account_id');
    }
    function external()
    {
        return $this->hasMany('App\Models\External', 'account_id', 'account_id');
    }
}
