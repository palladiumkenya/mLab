<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    public $table = 'printers_data';
    public $timestamps = false;
    public $incrementing = false;
    
    protected $fillable = [
        
    ];
}
