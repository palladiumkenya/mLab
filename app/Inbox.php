<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    public $table = 'inbox';
    public $timestamps = false;
    
    protected $fillable = [
    'shortCode', 'MSISDN', 'message', 'msgDateCreated', 'createdOn', 'message_id', 'processed', 'LinkId'
    ];
}
