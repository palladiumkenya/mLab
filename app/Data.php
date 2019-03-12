<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    public $table = 'summary';
    public $timestamps = false;
    public $incrementing = false;
    
    protected $fillable = [
        'id', 'partner','county','sub_county','facility','lat','lng','result_type','data_key','isVALID','gender','age','age_group','date_collected','date_sent', 'date_delivered', 'date_read', 'collected_sent_TAT','sent_read_TAT','overall_TAT','updated',
    ];
}
