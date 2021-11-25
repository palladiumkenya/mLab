<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SMSData;
use DB;
use Auth;
use Illuminate\Support\Carbon;


class SMSReportController extends Controller
{
    public function index(){

        return view('sms.sms');

    }

    public function get_data(){

        $cost = SMSData::selectRaw("to_char(created_at, 'YYYY-MM') as month, status , count(*) as y")
            ->where('partner_id', Auth::user()->partner_id )
            ->groupBy('month', 'status')
            ->orderBy('month', 'ASC')
            ->get();

        // status 101 
        // 101: Sent   
        $sent = SMSData::selectRaw("to_char(created_at, 'YYYY-MM') as month, status , count(*) as y")
            ->where('partner_id', Auth::user()->partner_id )
            ->orWhere('status', '=', 101)
            ->groupBy('month', 'status')
            ->orderBy('month', 'ASC')
            ->get();

        // status 500, 501, 502
        // 500: InternalServerError
        // 501: GatewayError
        // 502: RejectedByGateway
        $failed = SMSData::selectRaw("to_char(created_at, 'YYYY-MM') as month, status , count(*) as y")
            ->where('partner_id', Auth::user()->partner_id )
            ->orWhere('status', '=', 403)
            ->groupBy('month', 'status')
            ->orderBy('month', 'ASC')
            ->get();

        // status 406 
        // 406: UserInBlacklist  
        $blacklist = SMSData::selectRaw("to_char(created_at, 'YYYY-MM') as month, status , count(*) as y")
            ->where('partner_id', Auth::user()->partner_id )
            ->orWhere('status', '=', 406)
            ->groupBy('month', 'status')
            ->orderBy('month', 'ASC')
            ->get();

        
        $data["blacklist"] = $blacklist;
        $data["failed"] = $failed;
        $data["sent"] = $sent;
        $data["cost"] = $cost;

        return $data;

    }

    public function get_filtered_data(Request $request){

        $selected_dates = $request->daterange;

        $dates = explode('-', $selected_dates);

        $unformatted_startdate = trim($dates[0]);
        $unformatted_enddate = trim($dates[1]);

        $start_date = Carbon::createFromFormat('m/d/Y', $unformatted_startdate)->format('Y-m-d');
        $end_date = Carbon::createFromFormat('m/d/Y', $unformatted_enddate)->format('Y-m-d');

        $cost = SMSData::selectRaw("to_char(created_at, 'YYYY-MM') as month, status,count(*) as y")
            ->where('partner_id', Auth::user()->partner_id )
            ->whereBetween('created_at',[$start_date, $end_date] )
            ->groupBy('month', 'status')
            ->get();

        // status 101    
        $sent = SMSData::selectRaw("to_char(created_at, 'YYYY-MM') as month, status , count(*) as y")
            ->where('partner_id', Auth::user()->partner_id )
            ->whereBetween('created_at',[$start_date, $end_date] )
            ->orWhere('status', '=', 101)
            ->groupBy('month', 'status')
            ->orderBy('month', 'ASC')
            ->get();

        // status 500, 501, 502
        $failed = SMSData::selectRaw("to_char(created_at, 'YYYY-MM') as month, status , count(*) as y")
            ->where('partner_id', Auth::user()->partner_id )
            ->whereBetween('created_at',[$start_date, $end_date] )
            ->orWhere('status', '=', 403)
            ->groupBy('month', 'status')
            ->orderBy('month', 'ASC')
            ->get();

        // status 406   
        $blacklist = SMSData::selectRaw("to_char(created_at, 'YYYY-MM') as month, status , count(*) as y")
            ->where('partner_id', Auth::user()->partner_id )
            ->orWhere('status', '=', 406)
            ->groupBy('month', 'status')
            ->orderBy('month', 'ASC')
            ->get();

        $data["blacklist"] = $blacklist;
        $data["failed"] = $failed;
        $data["sent"] = $sent;
        $data["cost"] = $cost;

        return $data;

    }
}
