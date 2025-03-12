<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class OTP extends Model
{
    protected $table = 'account_otps';
    protected $primaryKey = 'account_otp_id';
    use HasFactory;
}
