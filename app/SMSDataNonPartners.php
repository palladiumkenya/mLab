<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMSDataNonPartners extends Model
{
    public $table = 'non_partner_sms';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'month', 'sum', 'failure_reason', 'status'
    ];
}
