<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PartnerCost;

class PartnerCostController extends Controller
{
    public function sms() {

        $costs = PartnerCost::all();

        return view('sms.cost')->with($costs);

    }

}
