<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dashboard;
use DB;
use App\Partner;
use App\County;
use App\SubCounty;
use App\Facility;
use Carbon\Carbon;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        Auth::user()->load('partner', 'facility', 'county');

        return view('dashboard.highcharts_dashboard');
    }

    public function get_data()
    {
        $data                = [];
        

      
        if (Auth::user()->user_level == 2) {
            $selected_partners = [Auth::user()->partner_id];
        }
        if (Auth::user()->user_level == 3) {
            $selected_facilities = [Auth::user()->facility_id];
        }
        if (Auth::user()->user_level == 5) {
            $selected_counties = [Auth::user()->county_id];
        }

        $partners_with_data = Dashboard::select('partner_id')->groupBy('partner_id');
        
        $counties_with_data = Dashboard::select('county_id')->groupBy('county_id');
        
        
        $all_partners = Partner::select('id', 'name')->whereIn('id', $partners_with_data);
        $all_counties = County::select('id', 'name')->distinct('id')->whereIn('id', $counties_with_data);

        $startdate = Dashboard::select('created_at')->orderBy('created_at', 'asc')->first();
        $startdate = Carbon::parse($startdate->created_at)->format('Y-m-d');
        $enddate  = Dashboard::select('created_at')->orderBy('created_at', 'desc')->first();
        $enddate = Carbon::parse($enddate->created_at)->format('Y-m-d');

        $all_records         = Dashboard::whereNotNull('mfl_code')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $sent_records        = Dashboard::whereNotNull('date_sent')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $counties            = Dashboard::distinct('county_id')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $facilities          = Dashboard::distinct('mfl_code')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $partners            = Dashboard::distinct('partner_id')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $vl_records          = Dashboard::where('result_type', 1)->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $eid_records         = Dashboard::where('result_type', 2)->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $vl_classifications  = Dashboard::where('result_type', 1)->selectRaw('data_key, count("result_type") AS number')->groupBy('result_type', 'data_key')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $eid_classifications = Dashboard::where('result_type', 2)->selectRaw('data_key, count("result_type") AS number')->groupBy('result_type', 'data_key')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $county_numbers      = Dashboard::selectRaw('county_id, count(*) AS results, count(DISTINCT(mfl_code)) as facilities')->groupBy('county_id')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $pulled_data      = Dashboard::join('county', 'county.id', '=', 'mlab_data.county_id')->selectRaw('county.NAME, COUNT ( mlab_data.created_at ) AS all_results,  count (mlab_data.date_sent) AS  pulled_results ')
                            ->groupBy('county.name')->orderBy('county.name')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);

        $average_vl_collect_sent_diff = Dashboard::selectRaw('AVG( date_sent::DATE - date_collected::DATE)')->where('result_type', '1')->whereRaw('(date_sent::DATE - date_collected::DATE) <= ?', [30])
                            ->whereNotNull('date_sent')->whereNotNull('date_collected')->where('date_collected', '!=', '0000-00-00')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $average_eid_collect_sent_diff = DB::table('mlab_data')->selectRaw('AVG( date_sent::DATE - date_collected::DATE)')->where('result_type', '2')
                            ->whereRaw('(date_sent::DATE - date_collected::DATE) <= ?', [30])->whereNotNull('date_sent')->whereNotNull('date_collected')->where('date_collected', '!=', '0000-00-00')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
    
        if (!empty($selected_partners)) {
            $all_partners = Partner::select('id', 'name')->whereIn('id', $selected_partners);
            $all_counties = $all_counties->join('mlab_data', 'county.id', '=', 'mlab_data.county_id')->whereIn('partner_id', $selected_partners);
            $all_records = $all_records->whereIn('partner_id', $selected_partners);
            $sent_records = $sent_records->whereIn('partner_id', $selected_partners);
            $counties = $counties->whereIn('partner_id', $selected_partners);
            $facilities = $facilities->whereIn('partner_id', $selected_partners);
            $partners = $partners->whereIn('partner_id', $selected_partners);
            $vl_records = $vl_records->whereIn('partner_id', $selected_partners);
            $eid_records = $eid_records->whereIn('partner_id', $selected_partners);
            $vl_classifications = $vl_classifications->whereIn('partner_id', $selected_partners);
            $eid_classifications = $eid_classifications->whereIn('partner_id', $selected_partners);
            $county_numbers = $county_numbers->whereIn('partner_id', $selected_partners);
            $pulled_data = $pulled_data->whereIn('partner_id', $selected_partners);
            $average_vl_collect_sent_diff = $average_vl_collect_sent_diff->whereIn('partner_id', $selected_partners);
            $average_eid_collect_sent_diff = $average_eid_collect_sent_diff->whereIn('partner_id', $selected_partners);
        }

        if (!empty($selected_counties)) {
            $all_counties = $all_counties->whereIn('county_id', $selected_counties);
            $all_records = $all_records->whereIn('county_id', $selected_counties);
            $sent_records = $sent_records->whereIn('county_id', $selected_counties);
            $counties = $counties->whereIn('county_id', $selected_counties);
            $facilities = $facilities->whereIn('county_id', $selected_counties);
            $partners = $partners->whereIn('county_id', $selected_counties);
            $vl_records = $vl_records->whereIn('county_id', $selected_counties);
            $eid_records = $eid_records->whereIn('county_id', $selected_counties);
            $vl_classifications = $vl_classifications->whereIn('county_id', $selected_counties);
            $eid_classifications = $eid_classifications->whereIn('county_id', $selected_counties);
            $county_numbers = $county_numbers->whereIn('county_id', $selected_counties);
            $pulled_data = $pulled_data->whereIn('county_id', $selected_counties);
            $average_vl_collect_sent_diff = $average_vl_collect_sent_diff->whereIn('county_id', $selected_counties);
            $average_eid_collect_sent_diff = $average_eid_collect_sent_diff->whereIn('county_id', $selected_counties);
        }


        if (!empty($selected_facilities)) {
            $all_partners = Partner::select('id', 'name')->where('id', Auth::user()->partner_id);
            $all_counties = $all_counties->join('mlab_data', 'county.id', '=', 'mlab_data.county_id')->whereIn('mfl_code', $selected_facilities);
            $all_records = $all_records->whereIn('mfl_code', $selected_facilities);
            $sent_records = $sent_records->whereIn('mfl_code', $selected_facilities);
            $counties = $counties->whereIn('mfl_code', $selected_facilities);
            $facilities = $facilities->whereIn('mfl_code', $selected_facilities);
            $partners = $partners->whereIn('mfl_code', $selected_facilities);
            $vl_records = $vl_records->whereIn('mfl_code', $selected_facilities);
            $eid_records = $eid_records->whereIn('mfl_code', $selected_facilities);
            $vl_classifications = $vl_classifications->whereIn('mfl_code', $selected_facilities);
            $eid_classifications = $eid_classifications->whereIn('mfl_code', $selected_facilities);
            $county_numbers = $county_numbers->whereIn('mfl_code', $selected_facilities);
            $pulled_data = $pulled_data->whereIn('mfl_code', $selected_facilities);
            $average_vl_collect_sent_diff = $average_vl_collect_sent_diff->whereIn('mfl_code', $selected_facilities);
            $average_eid_collect_sent_diff = $average_eid_collect_sent_diff->whereIn('mfl_code', $selected_facilities);
        }


        $data["all_counties"]        = $all_counties->get();
        $data["all_partners"]        = $all_partners->get();
        $data["all_records"]         = $all_records->count();
        $data["sent_records"]        = $sent_records->count();
        $data["counties"]            = $counties->count('county_id');
        $data["facilities"]          = $facilities->count('mfl_code');
        $data["partners"]            = $partners->count('partner_id');
        $data["vl_records"]          = $vl_records->count();
        $data["eid_records"]         = $eid_records->count();
        $data["vl_classifications"]  = $vl_classifications->get();
        $data["eid_classifications"] = $eid_classifications->get();
        $data["eid_tat"]             = $average_eid_collect_sent_diff->get();
        $data["vl_tat"]              = $average_vl_collect_sent_diff->get();
        $data["county_numbers"]      = $county_numbers->get();
        $data["pulled_data"]         = $pulled_data->get();
        return $data;
    }

    public function get_filtered_data(Request $request)
    {
        $data                = [];
        
        $selected_partners = $request->partners;
        $selected_counties = $request->counties;
        $selected_subcounties = $request->subcounties;
        $selected_facilites = $request->facilities;
        $selected_dates = $request->daterange;

        $dates = explode('-', $selected_dates);

        $unformatted_startdate = trim($dates[0]);
        $unformatted_enddate = trim($dates[1]);

        $startdate = Carbon::createFromFormat('m/d/Y', $unformatted_startdate)->format('Y-m-d');
        $enddate = Carbon::createFromFormat('m/d/Y', $unformatted_enddate)->format('Y-m-d');

        if (Auth::user()->user_level == 2) {
            $selected_partners = [Auth::user()->partner_id];
        }
        if (Auth::user()->user_level == 3) {
            $selected_facilities = [Auth::user()->facility_id];
        }
        if (Auth::user()->user_level == 5) {
            $selected_counties = [Auth::user()->county_id];
        }
        if (empty($selected_partners)) {
            $partners_with_data = Dashboard::select('partner_id')->groupBy('partner_id');
        } else {
            $partners_with_data = $selected_partners;
        }
        
        if (empty($selected_counties)) {
            $counties_with_data = Dashboard::select('county_id')->groupBy('county_id');
        } else {
            $counties_with_data = $selected_counties;
        }
        
        $all_partners = Partner::select('id', 'name')->whereIn('id', $partners_with_data);
        $all_counties = County::select('id', 'name')->distinct('id')->whereIn('id', $counties_with_data);

        $all_records         = Dashboard::whereNotNull('mfl_code')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $sent_records        = Dashboard::whereNotNull('date_sent')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $counties            = Dashboard::distinct('county_id')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $facilities          = Dashboard::distinct('mfl_code')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $partners            = Dashboard::distinct('partner_id')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $vl_records          = Dashboard::where('result_type', 1)->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $eid_records         = Dashboard::where('result_type', 2)->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $vl_classifications  = Dashboard::where('result_type', 1)->selectRaw('data_key, count("result_type") AS number')->groupBy('result_type', 'data_key')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $eid_classifications = Dashboard::where('result_type', 2)->selectRaw('data_key, count("result_type") AS number')->groupBy('result_type', 'data_key')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $county_numbers      = Dashboard::selectRaw('county_id, count(*) AS results, count(DISTINCT(mfl_code)) as facilities')->groupBy('county_id')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $pulled_data      = Dashboard::join('county', 'county.id', '=', 'mlab_data.county_id')->selectRaw('county.NAME, COUNT ( mlab_data.created_at ) AS all_results,  count (mlab_data.date_sent) AS  pulled_results ')
                            ->groupBy('county.name')->orderBy('county.name')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);

        $average_vl_collect_sent_diff = Dashboard::selectRaw('AVG( date_sent::DATE - date_collected::DATE)')->where('result_type', '1')->whereRaw('(date_sent::DATE - date_collected::DATE) <= ?', [30])
                            ->whereNotNull('date_sent')->whereNotNull('date_collected')->where('date_collected', '!=', '0000-00-00')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $average_eid_collect_sent_diff = DB::table('mlab_data')->selectRaw('AVG( date_sent::DATE - date_collected::DATE)')->where('result_type', '2')
                            ->whereRaw('(date_sent::DATE - date_collected::DATE) <= ?', [30])->whereNotNull('date_sent')->whereNotNull('date_collected')->where('date_collected', '!=', '0000-00-00')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
    
        if (!empty($selected_partners)) {
            $all_counties = $all_counties->join('mlab_data', 'county.id', '=', 'mlab_data.county_id')->whereIn('partner_id', $selected_partners);
            $all_records = $all_records->whereIn('partner_id', $selected_partners);
            $sent_records = $sent_records->whereIn('partner_id', $selected_partners);
            $counties = $counties->whereIn('partner_id', $selected_partners);
            $facilities = $facilities->whereIn('partner_id', $selected_partners);
            $partners = $partners->whereIn('partner_id', $selected_partners);
            $vl_records = $vl_records->whereIn('partner_id', $selected_partners);
            $eid_records = $eid_records->whereIn('partner_id', $selected_partners);
            $vl_classifications = $vl_classifications->whereIn('partner_id', $selected_partners);
            $eid_classifications = $eid_classifications->whereIn('partner_id', $selected_partners);
            $county_numbers = $county_numbers->whereIn('partner_id', $selected_partners);
            $pulled_data = $pulled_data->whereIn('partner_id', $selected_partners);
            $average_vl_collect_sent_diff = $average_vl_collect_sent_diff->whereIn('partner_id', $selected_partners);
            $average_eid_collect_sent_diff = $average_eid_collect_sent_diff->whereIn('partner_id', $selected_partners);
        }

        if (!empty($selected_counties)) {
            $all_counties = $all_counties->whereIn('county_id', $selected_counties);
            $all_records = $all_records->whereIn('county_id', $selected_counties);
            $sent_records = $sent_records->whereIn('county_id', $selected_counties);
            $counties = $counties->whereIn('county_id', $selected_counties);
            $facilities = $facilities->whereIn('county_id', $selected_counties);
            $partners = $partners->whereIn('county_id', $selected_counties);
            $vl_records = $vl_records->whereIn('county_id', $selected_counties);
            $eid_records = $eid_records->whereIn('county_id', $selected_counties);
            $vl_classifications = $vl_classifications->whereIn('county_id', $selected_counties);
            $eid_classifications = $eid_classifications->whereIn('county_id', $selected_counties);
            $county_numbers = $county_numbers->whereIn('county_id', $selected_counties);
            $pulled_data = $pulled_data->whereIn('county_id', $selected_counties);
            $average_vl_collect_sent_diff = $average_vl_collect_sent_diff->whereIn('county_id', $selected_counties);
            $average_eid_collect_sent_diff = $average_eid_collect_sent_diff->whereIn('county_id', $selected_counties);
        }

        if (!empty($selected_subcounties)) {
            $all_counties = $all_counties->whereIn('Sub_County_ID', $selected_subcounties);
            $all_records = $all_records->whereIn('Sub_County_ID', $selected_subcounties);
            $sent_records = $sent_records->whereIn('Sub_County_ID', $selected_subcounties);
            $counties = $counties->whereIn('Sub_County_ID', $selected_subcounties);
            $facilities = $facilities->whereIn('Sub_County_ID', $selected_subcounties);
            $partners = $partners->whereIn('Sub_County_ID', $selected_subcounties);
            $vl_records = $vl_records->whereIn('Sub_County_ID', $selected_subcounties);
            $eid_records = $eid_records->whereIn('Sub_County_ID', $selected_subcounties);
            $vl_classifications = $vl_classifications->whereIn('Sub_County_ID', $selected_subcounties);
            $eid_classifications = $eid_classifications->whereIn('Sub_County_ID', $selected_subcounties);
            $county_numbers = $county_numbers->whereIn('Sub_County_ID', $selected_subcounties);
            $pulled_data = $pulled_data->whereIn('Sub_County_ID', $selected_subcounties);
            $average_vl_collect_sent_diff = $average_vl_collect_sent_diff->whereIn('Sub_County_ID', $selected_subcounties);
            $average_eid_collect_sent_diff = $average_eid_collect_sent_diff->whereIn('Sub_County_ID', $selected_subcounties);
        }

        if (!empty($selected_facilities)) {
            $all_partners = Partner::select('id', 'name')->where('id', Auth::user()->partner_id);
            $all_counties = $all_counties->whereIn('mfl_code', $selected_facilities);
            $all_records = $all_records->whereIn('mfl_code', $selected_facilities);
            $sent_records = $sent_records->whereIn('mfl_code', $selected_facilities);
            $counties = $counties->whereIn('mfl_code', $selected_facilities);
            $facilities = $facilities->whereIn('mfl_code', $selected_facilities);
            $partners = $partners->whereIn('mfl_code', $selected_facilities);
            $vl_records = $vl_records->whereIn('mfl_code', $selected_facilities);
            $eid_records = $eid_records->whereIn('mfl_code', $selected_facilities);
            $vl_classifications = $vl_classifications->whereIn('mfl_code', $selected_facilities);
            $eid_classifications = $eid_classifications->whereIn('mfl_code', $selected_facilities);
            $county_numbers = $county_numbers->whereIn('mfl_code', $selected_facilities);
            $pulled_data = $pulled_data->whereIn('mfl_code', $selected_facilities);
            $average_vl_collect_sent_diff = $average_vl_collect_sent_diff->whereIn('mfl_code', $selected_facilities);
            $average_eid_collect_sent_diff = $average_eid_collect_sent_diff->whereIn('mfl_code', $selected_facilities);
        }


        $data["all_counties"]        = $all_counties->get();
        $data["all_partners"]        = $all_partners->get();
        $data["all_records"]         = $all_records->count();
        $data["sent_records"]        = $sent_records->count();
        $data["counties"]            = $counties->count('county_id');
        $data["facilities"]          = $facilities->count('mfl_code');
        $data["partners"]            = $partners->count('partner_id');
        $data["vl_records"]          = $vl_records->count();
        $data["eid_records"]         = $eid_records->count();
        $data["vl_classifications"]  = $vl_classifications->get();
        $data["eid_classifications"] = $eid_classifications->get();
        $data["eid_tat"]             = $average_eid_collect_sent_diff->get();
        $data["vl_tat"]              = $average_vl_collect_sent_diff->get();
        $data["county_numbers"]      = $county_numbers->get();
        $data["pulled_data"]         = $pulled_data->get();
        return $data;
    }


    public function get_dashboard_counties(Request $request)
    {
        $partner_ids = array();
        $strings_array = $request->partners;
        if (!empty($strings_array)) {
            foreach ($strings_array as $each_id) {
                $partner_ids[] = (int) $each_id;
            }
        }
        $counties_with_data = Dashboard::select('county_id')->distinct('county_id')->groupBy('county_id')->get();

        if (!empty($partner_ids)) {
            $all_counties = County::join('sub_county', 'county.id', '=', 'sub_county.county_id')
                ->join('health_facilities', 'sub_county.id', '=', 'health_facilities.Sub_County_ID')
                ->select('county.id as id', 'county.name as name')
                ->distinct('county.id')
                ->whereIn('health_facilities.partner_id', $partner_ids)
                ->whereIn('county.id', $counties_with_data)
                ->groupBy('county.id', 'county.name')
                ->get('county.id');
        } else {
            $all_counties = County::join('sub_county', 'county.id', '=', 'sub_county.county_id')
            ->join('health_facilities', 'sub_county.id', '=', 'health_facilities.Sub_County_ID')
            ->select('county.id as id', 'county.name as name')
            ->distinct('county.id')
            ->whereIn('county.id', $counties_with_data)
            ->groupBy('county.id', 'county.name')
            ->get();
        }
        return $all_counties;
    }

    public function get_dashboard_sub_counties(Request $request)
    {
        $county_ids = array();
        $strings_array = $request->counties;
        if (!empty($strings_array)) {
            foreach ($strings_array as $each_id) {
                $county_ids[] = (int) $each_id;
            }
        }
        $sub_counties_with_data = Dashboard::select('Sub_County_ID')->groupBy('Sub_County_ID')->get();
        if (!empty($county_ids)) {
            $all_sub_counties = SubCounty::select('id', 'name')->distinct('id')->wherein('county_id', $county_ids)->wherein('id', $sub_counties_with_data)->groupBy('id', 'name')->get();
        } else {
            $all_sub_counties = SubCounty::select('id', 'name')->distinct('id')->wherein('id', $sub_counties_with_data)->groupBy('id', 'name')->get();
        }
        return $all_sub_counties;
    }

    public function get_dashboard_facilities(Request $request)
    {
        $sub_county_ids = array();
        $strings_array = $request->sub_counties;
        $partner_ids = $request->partners;
        if (!empty($strings_array)) {
            foreach ($strings_array as $each_id) {
                $sub_county_ids[] = (int) $each_id;
            }
        }

        $withResults = Dashboard::select('mfl_code')->groupBy('mfl_code')->get();
     
        $all_facilities = Facility::select('code', 'name')->distinct('code')->wherein('Sub_County_ID', $sub_county_ids)->wherein('partner_id', $partner_ids)->wherein('code', $withResults)->groupBy('code', 'name')->get();
        
        return $all_facilities;
    }
}
