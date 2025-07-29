<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class CreateExam extends Model
{
    // use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exam_name','class_id','division_id','academic_year_id','role_id','semister_id','exam_start_date','exam_end_date' ];
        
    protected $casts = [
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
            'exam_start_date' => 'date:Y-m-d',
            'exam_end_date' => 'date:Y-m-d',
        ];
    
}
