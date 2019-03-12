<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ILFacility extends Model
{
    public $table = 'il_facilities';
    public $timestamps = false;
    
    protected $fillable = [
       'mfl_code', 'phone_no',
    ];

    public function facility(){
        return $this->belongsTo('App\Facility','mfl_code','code');
    }
}
