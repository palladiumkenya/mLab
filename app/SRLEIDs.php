<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SRLEIDs extends Model
{
    public $table = 'srl_eid';
    public $timestamps = false;
    
    protected $fillable = [
        'alive_dead', 'entry_point','patient_name','dob','date_collected','pcr','infant_feeding','prophylaxis_code','hein_number','selected_alive','selected_regimen','selected_sex','updated_at','processed','mother_age', 'haart_date'
    ];
}
