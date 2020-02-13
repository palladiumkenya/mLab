<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dashboard;
use DB;
use App\Partner;
use App\County;
use App\SubCounty;
use App\Facility;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.highcharts_dashboard');
    }

    public function get_data(Request $request)
    {
        $data                = [];

        $partners_with_data = Dashboard::select('partner_id')->groupBy('partner_id')->get();
        $counties_with_data = Dashboard::select('county_id')->groupBy('county_id')->get();
        $all_partners = Partner::select('id', 'name')->whereIn('id', $partners_with_data)->get();
        $all_counties = County::select('id', 'name')->whereIn('id', $counties_with_data)->get();

        $all_records         = Dashboard::count();
        $sent_records        = Dashboard::whereNotNull('date_sent')->count();
        $counties            = DB::table('mlab_data')->distinct('county_id')->count('county_id');
        $facilities          = DB::table('mlab_data')->distinct('mfl_code')->count('mfl_code');
        $partners            = DB::table('mlab_data')->distinct('partner_id')->count('partner_id');
        $vl_records          = Dashboard::where('result_type', 1)->count();
        $eid_records         = Dashboard::where('result_type', 2)->count();
        $vl_classifications  = Dashboard::where('result_type', 1)->selectRaw('data_key, count("result_type") AS number')->groupBy('result_type', 'data_key')->get();
        $eid_classifications = Dashboard::where('result_type', 2)->selectRaw('data_key, count("result_type") AS number')->groupBy('result_type', 'data_key')->get();
        $county_numbers      = Dashboard::selectRaw('county_id, count(*) AS results, count(DISTINCT(mfl_code)) as facilities')->groupBy('county_id')->get();
        $pulled_data      = Dashboard::join('county', 'county.id', '=', 'mlab_data.county_id')->selectRaw('county.NAME, COUNT ( mlab_data.created_at ) AS all_results,  count (mlab_data.date_sent) AS  pulled_results ')->groupBy('county.name')->orderBy('county.name')->get();

        $average_vl_collect_sent_diff = DB::table('mlab_data')
        ->selectRaw('AVG( date_sent::DATE - date_collected::DATE)')
        ->where('result_type', '1')
        ->whereRaw('(date_sent::DATE - date_collected::DATE) <= ?', [30])
        ->whereNotNull('date_sent')
        ->whereNotNull('date_collected')
        ->where('date_collected', '!=', '0000-00-00')
        ->get();
        $average_eid_collect_sent_diff = DB::table('mlab_data')
        ->selectRaw('AVG( date_sent::DATE - date_collected::DATE)')
        ->where('result_type', '2')
        ->whereRaw('(date_sent::DATE - date_collected::DATE) <= ?', [30])
        ->whereNotNull('date_sent')
        ->whereNotNull('date_collected')
        ->where('date_collected', '!=', '0000-00-00')
        ->get();

        $data["all_counties"]        = $all_counties;
        $data["all_partners"]        = $all_partners;
        $data["all_records"]         = $all_records;
        $data["sent_records"]        = $sent_records;
        $data["counties"]            = $counties;
        $data["facilities"]          = $facilities;
        $data["partners"]            = $partners;
        $data["vl_records"]          = $vl_records;
        $data["eid_records"]         = $eid_records;
        $data["vl_classifications"]  = $vl_classifications;
        $data["eid_classifications"] = $eid_classifications;
        $data["eid_tat"]             = $average_eid_collect_sent_diff;
        $data["vl_tat"]              = $average_vl_collect_sent_diff;
        $data["county_numbers"]      = $county_numbers;
        $data["pulled_data"]         = $pulled_data;

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
        $counties_with_data = Dashboard::select('county_id')->groupBy('county_id')->get();

        if (!empty($partner_ids)) {
            $all_counties = County::join('sub_county', 'county.id', '=', 'sub_county.county_id')
                ->join('health_facilities', 'sub_county.id', '=', 'health_facilities.Sub_County_ID')
                ->select('county.id as id', 'county.name as name')
                ->whereIn('health_facilities.partner_id', $partner_ids)
                ->whereIn('county.id', $counties_with_data)
                ->groupBy('county.id', 'county.name')
                ->get();
        } else {
            $all_counties = County::join('sub_county', 'county.id', '=', 'sub_county.county_id')
            ->join('health_facilities', 'sub_county.id', '=', 'health_facilities.Sub_County_ID')
            ->select('county.id as id', 'county.name as name')
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
            $all_sub_counties = SubCounty::select('id', 'name')->wherein('county_id', $county_ids)->wherein('id', $sub_counties_with_data)->groupBy('id', 'name')->get();
        } else {
            $all_sub_counties = SubCounty::select('id', 'name')->wherein('id', $sub_counties_with_data)->groupBy('id', 'name')->get();
        }
        return $all_sub_counties;
    }

    public function get_dashboard_facilities(Request $request)
    {
        $sub_county_ids = array();
        $strings_array = $request->sub_counties;
        if (!empty($strings_array)) {
            foreach ($strings_array as $each_id) {
                $sub_county_ids[] = (int) $each_id;
            }
        }

        $withResults = Dashboard::select('mfl_code')->groupBy('mfl_code')->get();
     
        $all_facilities = Facility::select('id', 'name')->wherein('Sub_County_ID', $sub_county_ids)->wherein('code', $withResults)->groupBy('id', 'name')->get();
        
        return $all_facilities;
    }
}
