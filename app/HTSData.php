<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HTSData extends Model
{
    public $table = 'hts_summary';
    public $timestamps = false;
    public $incrementing = false;
    
    protected $fillable = [
        'hts_result_id', 'partner','county','sub_county','facility','lat','lng','test','result_value','gender','age','submit_date','date_released', 'date_sent', 'date_delivered', 'date_read', 'submitted_released_tat','sent_read_tat','overall_tat','updated',
    ];

}
