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

            // successful  
            $success = SMSData::selectRaw("partner_name, CAST(sum(sum)as FLOAT) as y")
                ->where('status', '=', 'Success')
                ->groupBy('partner_name')
                ->orderBy('partner_name')
                ->get();

            // delivery failed 
            $delivery_failure = SMSData::selectRaw("month, CAST(sum(sum)as FLOAT) as y")
                ->where('failure_reason', '=', 'DeliveryFailure')
                ->groupBy('month')
                ->orderBy('month', 'ASC')
                ->get();

            // AbsentSubscriber
            $absent_subscriber = SMSData::selectRaw("month, CAST(sum(sum)as FLOAT) as y")
                ->where('failure_reason', '=', 'AbsentSubscriber')
                ->orWhere('failure_reason', '=', 'UserInBlackList')
                ->groupBy('month')
                ->orderBy('month', 'ASC')
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

            // successful  
            $success = SMSData::selectRaw("month, status, CAST(sum(sum) as FLOAT) as y")
                ->where('partner_id', Auth::user()->partner_id )
                ->where('status', '=', 'Success')
                ->groupBy('month', 'status')
                ->orderBy('month', 'ASC')
                ->get();

            // delivery failed 
            $delivery_failure = SMSData::selectRaw("month, status, CAST(sum(sum) as FLOAT) as y")
                ->where('partner_id', Auth::user()->partner_id )
                ->where('failure_reason', '=', 'DeliveryFailure')
                ->groupBy('month', 'status')
                ->orderBy('month', 'ASC')
                ->get();

            // AbsentSubscriber
            $absent_subscriber = SMSData::selectRaw("month, status , CAST(sum(sum)as FLOAT) as y")
                ->where('partner_id', Auth::user()->partner_id )
                ->where('failure_reason', '=', 'AbsentSubscriber')
                ->orWhere('failure_reason', '=', 'UserInBlackList')
                ->groupBy('month', 'status')
                ->orderBy('month', 'ASC')
                ->get();

        }

        
        $data["delivery_failure"] = $delivery_failure;
        $data["absent_subscriber"] = $absent_subscriber;
        $data["success"] = $success;
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

            // Success  
            $success = SMSData::selectRaw("partner_name, CAST(sum(sum)as FLOAT) as y")
                ->whereBetween('month',[$start_date, $end_date] )
                ->where('status', '=', 'Success')
                ->groupBy( 'partner_name')
                ->orderBy('partner_name')
                ->get();

            // DeliveryFailure  
            $delivery_failure = SMSData::selectRaw("month, CAST(sum(sum)as FLOAT) as y")
                ->whereBetween('month',[$start_date, $end_date] )
                ->where('failure_reason', '=', 'DeliveryFailure')
                ->groupBy('month')
                ->orderBy('month', 'ASC')
                ->get();

            // AbsentSubscriber
            $absent_subscriber = SMSData::selectRaw("month, CAST(sum(sum)as FLOAT) as y")
                ->whereBetween('month',[$start_date, $end_date] )
                ->where('failure_reason', '=', 'AbsentSubscriber')
                ->orWhere('failure_reason', '=', 'UserInBlackList')
                ->groupBy('month')
                ->orderBy('month', 'ASC')
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

            // success    
            $success = SMSData::selectRaw("month, status , CAST(sum(sum)as FLOAT) as y")
                ->where('partner_id', Auth::user()->partner_id )
                ->whereBetween('month',[$start_date, $end_date] )
                ->where('status', '=', 'success')
                ->groupBy('month', 'status')
                ->orderBy('month', 'ASC')
                ->get();

            // status 102 queued   
            $delivery_failure = SMSData::selectRaw("month, status , CAST(sum(sum)as FLOAT) as y")
                ->where('partner_id', Auth::user()->partner_id )
                ->whereBetween('month',[$start_date, $end_date] )
                ->where('failure_reason', '=', 'DeliveryFailure')
                ->groupBy('month', 'status')
                ->orderBy('month', 'ASC')
                ->get();

            // status 500, 501, 502
            $absent_subscriber = SMSData::selectRaw("month, status , CAST(sum(sum)as FLOAT) as y")
                ->where('partner_id', Auth::user()->partner_id )
                ->whereBetween('month',[$start_date, $end_date] )
                ->where('failure_reason', '=', 'AbsentSubscriber')
                ->orWhere('failure_reason', '=', 'UserInBlackList')
                ->groupBy('month', 'status')
                ->orderBy('month', 'ASC')
                ->get();

        }

        $data["delivery_failure"] = $delivery_failure;
        $data["success"] = $success;
        $data["absent_subscriber"] = $absent_subscriber;
        $data["cost"] = $cost;
        $data["total_sum"] = $total_sum;

        return $data;

    }
}
