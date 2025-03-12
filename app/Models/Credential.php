<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    protected $table = 'account_credentials';
    protected $primaryKey = 'account_credential_id';
    use HasFactory;
}
