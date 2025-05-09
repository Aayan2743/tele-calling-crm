<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $guarded = [];

    public $timestamps=false;

    
public function staff()
{
    return $this->belongsTo(User::class, 'staff_id');
}

}
