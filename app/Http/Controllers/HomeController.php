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
        $username = 'viewer'; // Username  
        $server = 'https://tableau.mhealthkenya.co.ke/trusted';  // Tableau URL  
        if(Auth::user()->user_level < 2){
                $view = "views/MLABDASH_0/MDSBD?iframeSizedToWindow=true&:embed=y&:showAppBanner=false&:display_count=no&:showVizHome=no"; 
        }
        if(Auth::user()->user_level == 2){
                $aff = str_replace(' ', '%20', Auth::user()->partner->name);
                $view = "views/MLABDASH_0/PartnerDSBD?iframeSizedToWindow=true&:embed=y&:showAppBanner=false&:display_count=no&:showVizHome=no&partner=".$aff;
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
    public function get_partner_facilities_mlab(Request $request)
    {
            $sub_county_id = $request->sub_county_id;

            
            $facilities = Facility::where('Sub_County_ID', $sub_county_id)->where('partner_id', Auth::user()->partner->id)->get();

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

