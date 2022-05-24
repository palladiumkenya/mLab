<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SRLEIData extends Model
{
    public $table = 'srl_eid_summary';
    public $timestamps = false;
    public $incrementing = false;
    
    protected $fillable = [
        'entry_point', 'partner','county','sub_county','facility','prophylaxis_code','lab_name','created_at','updated_at',
    ];

}
