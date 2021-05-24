<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubCounty;
use App\County;
use App\Facility;
use App\Unit;
use Auth; 

class HomeController extends Controller
{
    public function index()
    {
        Auth::user()->load('program', 'facility', 'county');
        $username = 'viewer'; // Username  
        $server = 'https://tableau.mhealthkenya.co.ke/trusted';  // Tableau URL  
        if(Auth::user()->user_level < 2){
                $view = "views/MLABDASH_0/MDSBD?iframeSizedToWindow=true&:embed=y&:showAppBanner=false&:display_count=no&:showVizHome=no"; 
        }
        if(Auth::user()->user_level == 2){
                $aff = str_replace(' ', '%20', Auth::user()->program->name);
                $view = "views/MLABDASH_0/programDSBD?iframeSizedToWindow=true&:embed=y&:showAppBanner=false&:display_count=no&:showVizHome=no&program=".$aff;
        }
        if(Auth::user()->user_level == 3 || Auth::user()->user_level == 4){
                $aff = str_replace(' ', '%20', Auth::user()->facility->name);
                $view = "views/MLABDASH_0/FacilityDSBD?iframeSizedToWindow=true&:embed=y&:showAppBanner=false&:display_count=no&:showVizHome=no&facility=".$aff;
                
        }
        if(Auth::user()->user_level == 5){
                $aff = str_replace(' ', '%20', Auth::user()->county->name);
                $view = "views/MLABDASH_0/CountyDashboard?iframeSizedToWindow=true&:embed=y&:showAppBanner=false&:display_count=no&:showVizHome=no&county=".$aff;
        }

        $ch = curl_init($server); // Initializes cURL session 



        $data = array('username' => $username); // What data to send to Tableau Server  

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true); // Tells cURL to use POST method  
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // What data to post  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return ticket to variable  


        $ticket = curl_exec($ch); // Execute cURL function and retrieve ticket  
        curl_close($ch); // Close cURL session  
        $clnd_view = str_replace(' ', '%20', $view);
        $url = $server . '/' . $ticket . '/' . $clnd_view;

        
        return view('dashboard.dashboardv1')->with('url', $url);
       
    }

    public function get_units(Request $request)
    {
        $program_id = $request->program_id;

        $units = Unit::where('program_id', $program_id)->get();

        return $units;
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

            
            $facilities = Facility::where('Sub_County_ID', $sub_county_id)->whereNull('program_id')->whereNull('mobile')->get();

            return $facilities;
    }
    public function get_program_facilities_mlab(Request $request)
    {
            $sub_county_id = $request->sub_county_id;

            
            $facilities = Facility::where('Sub_County_ID', $sub_county_id)->where('unit_id', Auth::user()->unit->id)->get();

            return $facilities;
    }

    public function get_facilities_data(Request $request)
    {
            $sub_county_id = $request->sub_county_id;

            
            $facilities = Facility::whereNotNull('unit_id')->whereNotNull('mobile')->where('Sub_County_ID', $sub_county_id)->doesnthave('il')->get();

            return $facilities;
    }
    public function get_counties(Request $request)
    {
            $unit_id = $request->unit_id;


            $cs= SubCounty::join("health_facilities", "health_facilities.Sub_County_ID",  "=",  "sub_county.id")
                ->select('sub_county.county_id')
                ->where('health_facilities.unit_id', $unit_id)
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

