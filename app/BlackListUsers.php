<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlackListUsers extends Model
{
    public $table = 'blacklist_users';
    public $timestamps = false;
    
    protected $fillable = [
        'id', 'phone_number'
    ];
}
