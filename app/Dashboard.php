<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    public $table = 'mlab_data';
    public $timestamps = false;
    public $incrementing = false;
    
    protected $fillable = [
        
    ];
}
