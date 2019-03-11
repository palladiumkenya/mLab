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
}
