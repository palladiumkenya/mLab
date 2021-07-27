<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartnerCost extends Model
{
    public $table = 'partner_costs';
    public $timestamps = false;
    public $incrementing = false;
    
    protected $fillable = [
        'partner', 'cost', 'sum', 'created_at'
    ];
}
