<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Track extends Model
{
    protected $table = 'account_trackings';
    protected $primaryKey = 'account_tracking_id';
    use HasFactory;
}
