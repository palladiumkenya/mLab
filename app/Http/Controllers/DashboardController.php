<?php

namespace App\Http\Controllers;

use App\Dashboard;
use DB;

class DashboardController extends Controller
{
 public function index()
 {

  $data                = [];
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

  echo json_encode($data);
 }
}
