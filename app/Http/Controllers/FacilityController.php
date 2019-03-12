<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facility;

class FacilityController extends Controller
{
    public function index(){

        $facilities = Facility::with('sub_county.county','partner')->whereNotNull('mobile')->whereNotNull('partner_id')->whereNotNull('email')->get();

        return view('facility.facility')->with('facilities', $facilities);
    }
    
}
