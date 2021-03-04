<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SRLVLs extends Model
{
    public $table = 'srl_viral_loads';
    public $timestamps = false;
    
    protected $fillable = [
        'ccc_num', 'patient_name','dob','date_collected','art_start_date','current_regimen','date_art_regimen','art_line','justification_code','selected_type','selected_sex','updated_at','processed', 'lab_id', 'lab_name'
    ];
}
