<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class service extends Model
{
    public $table = 'service';
    public $timestamps = false;
    
    protected $fillable = [
       'name', 'status', 
    ];
}
