<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    public $table = 'unit';
    public $timestamps = false;

    protected $fillable = [
        'name', 'status'
    ];
}