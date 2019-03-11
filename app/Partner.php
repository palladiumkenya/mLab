<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    public $table = 'partner';
    public $timestamps = false;
    
    protected $fillable = [
       'name', 'status', 
    ];
}
