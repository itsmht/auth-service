<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VerificationOTP extends Model
{
    protected $table = 'verification_otps';
    protected $primaryKey = 'verification_otp_id';
    use HasFactory;
}
