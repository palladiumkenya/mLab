<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCounty extends Model
{
    public $table = 'sub_county';
    public $timestamps = false;
    
    protected $fillable = [
        'name', 'satus', 'county_id',
    ];

    public function county(){
        return $this->belongsTo('App\County','county_id','id');
    }
}
