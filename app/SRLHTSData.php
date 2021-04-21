<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SRLHTSData extends Model
{
    public $table = 'srl_hts_summary';
    public $timestamps = false;
    public $incrementing = false;
    
    protected $fillable = [
        'sample_number', 'partner','county','sub_county','facility','client_name','gender','','lab_name','selected_delivery_point','selected_final_result','selected_test_kit1','selected_test_kit2','dbs_dispatch_date','created_at','updated_at',
    ];
    
}
