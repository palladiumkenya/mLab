<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubCounty;
use App\Facility;
use Auth; 

class HomeController extends Controller
{
    public function index()
    {
        Auth::user()->load('partner', 'facility', 'county');

        return view('dashboard.dashboardv1');
       
    }


    public function get_subcounties(Request $request)
    {
            $county_id = $request->county_id;

            $subcounties = SubCounty::where('county_id', $county_id)->get();

            return $subcounties;
    } 
    
    public function get_facilities(Request $request)
    {
            $sub_county_id = $request->sub_county_id;

            
            $facilities = Facility::where('Sub_County_ID', $sub_county_id)->doesnthave('il')->get();

            return $facilities;
    }
}
