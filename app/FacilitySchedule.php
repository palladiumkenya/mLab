<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacilitySchedule extends Model
{
    public $table = 'schedule_legacy';
    public $timestamps = false;
    
    protected $fillable = [
       'mfl_code', 'd_month', 'ispulled',
    ];
}
