<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
   use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'f_name', 'l_name', 'email', 'phone_no','status', 'county_id', 'program_id', 'user_level', 'facility_id', 'notified', 'first_login', 'created_at', 'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function program(){
        return $this->belongsTo('App\Program','program_id','id');
    }

    public function facility(){
        return $this->belongsTo('App\Facility','facility_id','code');
    }

    public function county(){
        return $this->belongsTo('App\County','county_id','id');
    }
}
