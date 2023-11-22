<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Outbox extends Model
{
    public $table = 'send_log';
    public $timestamps = false;
    protected $primaryKey = 'send_log_id';

    protected $fillable = [
        'number', 'status', 'messageId', 'message', 'cost', 'updated_at', 'created_at', 'failure_reason'
    ];
}
