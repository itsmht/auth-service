<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class External extends Model
{
    protected $table = 'account_externals';
    protected $primaryKey = 'account_external_id';
    use HasFactory;
}
