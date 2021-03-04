<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SRLHTS extends Model
{
    public $table = 'srl_hts';
    public $timestamps = false;
    
    protected $fillable = [
        'sample_number', 'client_name','dob','selected_sex','telephone','test_date','selected_delivery_point','selected_test_kit1','lot_number1','expiry_date1','selected_test_kit2','lot_number2','expiry_date2','selected_final_result', 'sample_tester_name', 'dbs_date','dbs_dispatch_date', 'requesting_provider', 'updated_at','processed', 'lab_id', 'lab_name'
    ];
}
