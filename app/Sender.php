<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sender extends Model
{
    public $table = 'send_log';
    public $timestamps = false;
    protected $primaryKey = 'send_log_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number', 'statusCode', 'status', 'messageId', 'message', 'cost', 'updated_at', 'created_at'
    ];
}
