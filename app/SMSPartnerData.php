<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMSPartnerData extends Model
{
    public $table = 'partner_sms_summary';
    public $timestamps = false;
    protected $primaryKey = 'send_log_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'partner_name', 'partner_id', 'total', 'status', 'created_at'
    ];
}
