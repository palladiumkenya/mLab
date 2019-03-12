<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    public $table = 'health_facilities';
    public $timestamps = false;
    
    protected $fillable = [
       'code', 'name', 'keph_level', 'facility_type', 'mobile', 'email', 'modified',
    ];

    public function sub_county(){
        return $this->belongsTo('App\SubCounty','Sub_County_ID','id');
    }
    public function partner(){
        return $this->belongsTo('App\Partner','partner_id','id');
    }

    public function il(){
        return $this->hasOne('App\ILFacility', 'mfl_code', 'code');
    }
}
