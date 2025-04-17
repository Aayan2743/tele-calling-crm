<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //

    public $table = "payments";

    protected $guarded = [];

    public  $timestamps = false;
}
