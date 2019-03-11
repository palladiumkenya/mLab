<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    public $table = 'county';
    public $timestamps = false;
    
    protected $fillable = [
        'name', 'satus'
    ];
}
