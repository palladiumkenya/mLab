<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubCounty;
use App\County;
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

    public function get_facilities_mlab(Request $request)
    {
            $sub_county_id = $request->sub_county_id;

            
            $facilities = Facility::where('Sub_County_ID', $sub_county_id)->whereNull('partner_id')->whereNull('mobile')->get();

            return $facilities;
    }

    public function get_facilities_data(Request $request)
    {
            $sub_county_id = $request->sub_county_id;

            
            $facilities = Facility::whereNotNull('partner_id')->whereNotNull('mobile')->where('Sub_County_ID', $sub_county_id)->doesnthave('il')->get();

            return $facilities;
    }
    public function get_counties(Request $request)
    {
            $partner_id = $request->partner_id;


            $cs= SubCounty::join("health_facilities", "health_facilities.Sub_County_ID",  "=",  "sub_county.id")
                ->select('sub_county.county_id')
                ->where('health_facilities.partner_id', $partner_id)
                ->get();


            $cids = [];

            foreach($cs AS $c){
                array_push($cids, $c->county_id);
            }

            $cn = array_unique($cids);

            
            $counties = County::whereIn('id', $cn)->get();

            return $counties;
    }
}
