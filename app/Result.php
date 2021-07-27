<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    public $table = 'results';
    public $timestamps = false;
    
    protected $fillable = [
        'source', 'result_id','result_type','request_id','age','kdod_number','result_content','gender','units','mfl_code','lab_id','cst','cj','csr', 'date_collected', 'lab_order_date',
    ];
}
