<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class CreateSubjectDetails extends Model
{
    // use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'create_subject_id','question_number_id','question_type_id','question_part_id','question_mark_id','question','ideal_answer','ideal_answer_status',
		'ideal_ans1','ideal_ans1_status','ideal_ans2','ideal_ans2_status','ideal_ans3','ideal_ans3_status','ideal_ans4','ideal_ans4_status','created_at','updated_at'
    ];

    
}
