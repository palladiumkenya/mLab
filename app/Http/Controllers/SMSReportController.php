<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SMSData;
use DB;
use Auth;
use App\Partner;
use Illuminate\Support\Carbon;


class SMSReportController extends Controller
{
    public function index(){

        if(Auth::user()->user_level == 1) {

            $partners = Partner::all();
            return view('sms.adminsms')->with('partners');
        } else if(Auth::user()->user_level == 2) {
            return view('sms.partnersms');
        }

    }

    public function get_data(){

        if(Auth::user()->user_level == 1) {

            $total_sum = SMSData::selectRaw("sum(sum) as total")->get();

            $cost = SMSData::selectRaw("partner_name, CAST(sum(sum) as FLOAT) as total")
            ->groupBy('partner_name')
            ->orderBy('partner_name')
            ->get();

            // status 101 
            // 101: Sent   
            $sent = SMSData::selectRaw("partner_name, CAST(sum(sum)as FLOAT) as y")
                ->where('status', '=', 101)
                ->groupBy('partner_name')
                ->orderBy('partner_name')
                ->get();

            // 102: Queued   
            $queued = SMSData::selectRaw("partner_name, CAST(sum(sum)as FLOAT) as y")
                ->where('status', '=', 102)
                ->groupBy('partner_name')
                ->orderBy('partner_name')
                ->get();

            // status 500, 501, 502
            // 500: InternalServerError
            // 501: GatewayError
            // 502: RejectedByGateway
            $failed = SMSData::selectRaw("partner_name, CAST(sum(sum)as FLOAT) as y")
                ->where('status', '=', 403)
                ->groupBy( 'partner_name')
                ->orderBy('partner_name')
                ->get();

            // status 406 
            // 406: UserInBlacklist  
            $blacklist = SMSData::selectRaw("partner_name, CAST(sum(sum)as FLOAT) as y")
                ->where('status', '=', 406)
                ->groupBy( 'partner_name')
                ->orderBy('partner_name')
                ->get();

        } else if(Auth::user()->user_level == 2) {

            $total_sum = SMSData::selectRaw("CAST(sum(sum) as FLOAT) as total")
            ->where('partner_id', Auth::user()->partner_id )
            ->get();

            $cost = SMSData::selectRaw("month, CAST(sum(sum) as FLOAT) as y")
            ->where('partner_id', Auth::user()->partner_id )
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get();

            // status 101 
            // 101: Sent   
            $sent = SMSData::selectRaw("month, status, CAST(sum(sum) as FLOAT) as y")
                ->where('partner_id', Auth::user()->partner_id )
                ->where('status', '=', 101)
                ->groupBy('month', 'status')
                ->orderBy('month', 'ASC')
                ->get();

            // 102: Queued  
            $queued = SMSData::selectRaw("month, status, CAST(sum(sum) as FLOAT) as y")
                ->where('partner_id', Auth::user()->partner_id )
                ->where('status', '=', 102)
                ->groupBy('month', 'status')
                ->orderBy('month', 'ASC')
                ->get();

            // status 500, 501, 502
            // 500: InternalServerError
            // 501: GatewayError
            // 502: RejectedByGateway
            $failed = SMSData::selectRaw("month, status , CAST(sum(sum)as FLOAT) as y")
                ->where('partner_id', Auth::user()->partner_id )
                ->where('status', '=', 403)
                ->groupBy('month', 'status')
                ->orderBy('month', 'ASC')
                ->get();

            // status 406 
            // 406: UserInBlacklist  
            $blacklist = SMSData::selectRaw("month, status , CAST(sum(sum)as FLOAT) as y")
                ->where('partner_id', Auth::user()->partner_id )
                ->where('status', '=', 406)
                ->groupBy('month','status')
                ->orderBy('month', 'ASC')
                ->get();
        }

        
        $data["blacklist"] = $blacklist;
        $data["failed"] = $failed;
        $data["queued"] = $queued;
        $data["sent"] = $sent;
        $data["cost"] = $cost;
        $data["total_sum"] = $total_sum;

        return $data;

    }

    public function get_filtered_data(Request $request){

        $selected_dates = $request->daterange;

        $dates = explode('-', $selected_dates);

        $unformatted_startdate = trim($dates[0]);
        $unformatted_enddate = trim($dates[1]);

        $start_date = Carbon::createFromFormat('m/d/Y', $unformatted_startdate)->format('Y-m-d');
        $end_date = Carbon::createFromFormat('m/d/Y', $unformatted_enddate)->format('Y-m-d');

        if(Auth::user()->user_level == 1) {

            $total_sum = SMSData::selectRaw("CAST(sum(sum)as FLOAT) as total")
            ->whereBetween('month',[$start_date, $end_date] )
            ->get();

            $cost = SMSData::selectRaw("partner_name, CAST(sum(sum)as FLOAT) as y")
                ->whereBetween('month',[$start_date, $end_date] )
                ->groupBy('partner_name')
                ->orderBy('partner_name')
                ->get();

            // status 101    
            $sent = SMSData::selectRaw("partner_name, CAST(sum(sum)as FLOAT) as y")
                ->whereBetween('month',[$start_date, $end_date] )
                ->where('status', '=', 101)
                ->groupBy( 'partner_name')
                ->orderBy('partner_name')
                ->get();

            // status 102 Queued    
            $queued = SMSData::selectRaw("partner_name, CAST(sum(sum)as FLOAT) as y")
                ->whereBetween('month',[$start_date, $end_date] )
                ->where('status', '=', 102)
                ->groupBy( 'partner_name')
                ->orderBy('partner_name')
                ->get();

            // status 500, 501, 502
            $failed = SMSData::selectRaw("partner_name, CAST(sum(sum)as FLOAT) as y")
                ->whereBetween('month',[$start_date, $end_date] )
                ->where('status', '=', 403)
                ->groupBy('partner_name')
                ->orderBy('partner_name')
                ->get();

            // status 406   
            $blacklist = SMSData::selectRaw("partner_name, CAST(sum(sum)as FLOAT) as y")
                ->where('status', '=', 406)
                ->groupBy('partner_name')
                ->orderBy('partner_name')
                ->get();

        } else if(Auth::user()->user_level == 2) {

            $total_sum = SMSData::selectRaw("CAST(sum(sum)as FLOAT) as total")
            ->where('partner_id', Auth::user()->partner_id )
            ->whereBetween('month',[$start_date, $end_date] )
            ->get();

            $cost = SMSData::selectRaw("month, status, CAST(sum(sum)as FLOAT) as y")
                ->where('partner_id', Auth::user()->partner_id )
                ->whereBetween('month',[$start_date, $end_date] )
                ->groupBy('month', 'status')
                ->get();

            // status 101    
            $sent = SMSData::selectRaw("month, status , CAST(sum(sum)as FLOAT) as y")
                ->where('partner_id', Auth::user()->partner_id )
                ->whereBetween('month',[$start_date, $end_date] )
                ->where('status', '=', 101)
                ->groupBy('month', 'status')
                ->orderBy('month', 'ASC')
                ->get();

            // status 102 queued   
            $queued = SMSData::selectRaw("month, status , CAST(sum(sum)as FLOAT) as y")
                ->where('partner_id', Auth::user()->partner_id )
                ->whereBetween('month',[$start_date, $end_date] )
                ->where('status', '=', 102)
                ->groupBy('month', 'status')
                ->orderBy('month', 'ASC')
                ->get();

            // status 500, 501, 502
            $failed = SMSData::selectRaw("month, status , CAST(sum(sum)as FLOAT) as y")
                ->where('partner_id', Auth::user()->partner_id )
                ->whereBetween('month',[$start_date, $end_date] )
                ->where('status', '=', 403)
                ->groupBy('month', 'status')
                ->orderBy('month', 'ASC')
                ->get();

            // status 406   
            $blacklist = SMSData::selectRaw("month, status , CAST(sum(sum)as FLOAT) as y")
                ->where('partner_id', Auth::user()->partner_id )
                ->where('status', '=', 406)
                ->groupBy('month', 'status')
                ->orderBy('month', 'ASC')
                ->get();
        }

        $data["blacklist"] = $blacklist;
        $data["failed"] = $failed;
        $data["sent"] = $sent;
        $data["queued"] = $queued;
        $data["cost"] = $cost;
        $data["total_sum"] = $total_sum;

        return $data;

    }
}
