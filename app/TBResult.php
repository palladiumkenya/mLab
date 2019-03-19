<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TBResult extends Model
{
    public $table = 'tb_results';
    protected $primaryKey = 'tb_result_id';
    public $timestamps = false;
    
    protected $fillable = [
        'sample_id', 'patient_id','age','gender','test1','result_value1','test2','result_value2','test3','result_value3','mfl_code','login_date','date_reviewed','record_date','testing_lab', 'created_at', 'updated_at',
    ];

    
}
