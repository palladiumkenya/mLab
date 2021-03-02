<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SRLVLData extends Model
{
    public $table = 'srl_vl_summary';
    public $timestamps = false;
    public $incrementing = false;
    
    protected $fillable = [
        'justification_code','current_regimen','date_art_regimen','selected_type','partner','county','sub_county','facility','lab_name','created_at','updated_at',
    ];
}
