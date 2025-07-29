<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class ScannerProfile extends Model
{
    // use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','phone_no','employee_id','email_id','date_of_joining','city','state','country','profile_pic','password','confirm_password','role_id','created_at','updated_at'
    ];

    
}