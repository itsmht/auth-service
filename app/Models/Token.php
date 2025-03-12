<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Token extends Model
{
    protected $table = 'account_tokens';
    protected $primaryKey = 'account_token_id';
    use HasFactory;
}
