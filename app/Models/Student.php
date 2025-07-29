<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    // use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name','email','password','date_of_birth','aadhar_number','mobile','address','uid_number','role','institute_id','division_id','class_id','academic_id','scanner_mid','image_url','confirm_password','created_at','updated_at'
    ];

    
}