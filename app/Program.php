<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    public $table = 'program';
    public $timestamps = false;
    
    protected $fillable = [
       'name', 'status', 
    ];
}
