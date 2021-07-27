<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HTSResult extends Model
{
    public $table = 'hts_results';
    protected $primaryKey = 'hts_result_id';
    public $timestamps = false;
    
    protected $fillable = [
        'nhrl_lab_id', 'kdod_number','age','gender','test','result_value','status','component','mfl_code','submit_date','date_released', 'created_at', 'updated_at',
    ];
}
