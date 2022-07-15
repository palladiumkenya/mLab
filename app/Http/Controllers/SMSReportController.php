<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SMSData;
use App\SMSDataNonPartners;
use App\SMSPartnerData;
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

            // total sum
            $total_sum = SMSData::selectRaw("CEIL(sum(sum)) as total")->get();

            // pie chart total breakdown
            $breakdown = SMSData::selectRaw("status,failure_reason, CEIL(sum(sum)) as total")
            ->groupBy('status', 'failure_reason')
            ->get();

            $cost = SMSData::selectRaw("partner_name, CEIL(sum(sum)) as total")
            ->groupBy('partner_name')
            ->orderBy('total', 'DESC')
            ->get();

            // successful
            $success = SMSPartnerData::selectRaw("partner_name, CEIL(sum(sum)) as y")
                ->where('status', '=', 'Success')
                ->whereNotNull('partner_name')
                ->groupBy('partner_name')
                ->orderBy('y', 'DESC')
                ->get();

            //successful non partner
            $successNonPartner = SMSDataNonPartners::selectRaw("month, CEIL(sum(sum)) as y")
                ->where('status', '=', 'Success')
                ->groupBy('month')
                ->orderBy('month', 'DESC')
                ->get();

            // successful county
            $successPerCounty = SMSData::selectRaw("county, CEIL(sum(sum)) as y")
                ->where('status', '=', 'Success')
                ->groupBy('county')
                ->orderBy('y', 'DESC')
                ->get();

            // delivery failed
            $delivery_failure = SMSData::selectRaw("month, CEIL(sum(sum)) as y")
                ->where('failure_reason', '=', 'DeliveryFailure')
                ->groupBy('month')
                ->orderBy('month', 'DESC')
                ->get();

            // AbsentSubscriber
            $absent_subscriber = SMSData::selectRaw("month, CEIL(sum(sum)) as y")
                ->whereNotIn('failure_reason', ['', 'DeliveryFailure'])
                ->groupBy( 'month')
                ->orderBy('month', 'DESC')
                ->get();


        } else if(Auth::user()->user_level == 2) {

            $total_sum = SMSData::selectRaw("CEIL(sum(sum)) as total")
            ->where('partner_id', Auth::user()->partner_id )
            ->get();

            // pie chart total breakdown
            $breakdown = SMSData::selectRaw("status, failure_reason, CEIL(sum(sum)) as total")
            ->where('partner_id', Auth::user()->partner_id )
            ->groupBy('status', 'failure_reason')
            ->get();

            $cost = SMSData::selectRaw("month, CEIL(sum(sum)) as y")
            ->where('partner_id', Auth::user()->partner_id )
            ->groupBy('month')
            ->orderBy('month', 'DESC')
            ->get();

            // successful
            $success = SMSData::selectRaw("month, CEIL(sum(sum)) as y")
                ->where('partner_id', Auth::user()->partner_id )
                ->where('status', '=', 'Success')
                ->groupBy('month')
                ->orderBy('month', 'DESC')
                ->get();

            $successNonPartner = [];

            $successPerCounty = [];

            // delivery failed
            $delivery_failure = SMSData::selectRaw("month, CEIL(sum(sum)) as y")
                ->where('partner_id', Auth::user()->partner_id )
                ->where('failure_reason', '=', 'DeliveryFailure')
                ->groupBy('month')
                ->orderBy('month', 'DESC')
                ->get();

            // AbsentSubscriber
            $absent_subscriber = SMSData::selectRaw("month, CEIL(sum(sum)) as y")
                ->where('partner_id', Auth::user()->partner_id )
                ->whereNotIn('failure_reason', ['', 'DeliveryFailure'])
                ->groupBy('month')
                ->orderBy('month', 'DESC')
                ->get();

        }


        $data["delivery_failure"] = $delivery_failure;
        $data["absent_subscriber"] = $absent_subscriber;
        $data["success"] = $success;
        $data["successNonPartner"] = $successNonPartner;
        $data["successPerCounty"] = $successPerCounty;
        $data["cost"] = $cost;
        $data["total_sum"] = $total_sum;
        $data["breakdown"] = $breakdown;

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

            $total_sum = DB::table('partners_sms')->select(DB::raw('sum(sum) as total'))
            ->whereBetween('created_at', [new Carbon($start_date), new Carbon($end_date)])
            ->get();

            // pie chart total breakdown
            $breakdown = DB::table('partners_sms')->select(DB::raw('status, failure_reason, sum(sum) as total'))
            ->whereBetween('created_at', [new Carbon($start_date), new Carbon($end_date)])
            ->groupBy('status', 'failure_reason')
            ->get();

            $cost = DB::table('partners_sms')->select(DB::raw('partner_name, sum(sum) as total'))
            ->whereBetween('created_at', [new Carbon($start_date), new Carbon($end_date)])
            ->orderBy('total', 'DESC')
            ->groupBy('partner_name')
            ->get();

            $success = DB::table('partner_sms_summary')->select(DB::raw('partner_name, sum(sum) as y'))
            ->whereBetween('created_at', [new Carbon($start_date), new Carbon($end_date)])
            ->where('status', '=', 'Success')
            ->groupBy('partner_name')
            ->orderBy('y', 'DESC')
            ->get();

            $successPerCounty = DB::table('partners_sms')->select(DB::raw('county, sum(sum) as y'))
                ->whereBetween('created_at', [new Carbon($start_date), new Carbon($end_date)])
                ->where('status', '=', 'Success')
                ->groupBy('county')
                ->orderBy('y', 'DESC')
                ->get();

            // $successNonPartner = DB::table('non_partner_sms')->select(DB::raw('month, sum(sum) as y'))
            //     ->whereBetween('created_at', [new Carbon($start_date), new Carbon($end_date)])
            //     ->where('status', '=', 'Success')
            //     ->groupBy('month')
            //     ->orderBy('month', 'DESC')
            //     ->get();

            // $successNonPartner = SMSDataNonPartners::select(
            //     DB::raw("(sum(sum)) as total"),
            //     DB::raw("(DATE_FORMAT(created_at::date, '%m-%Y')) as month")
            //     )
            //     ->orderBy('created_at', 'desc')
            //     ->groupBy(DB::raw("DATE_FORMAT(created_at::date, '%m-%Y')"))
            //     ->get();

            $successNonPartner = SMSDataNonPartners::selectRaw("month, CEIL(sum(sum)) as y")
                ->whereBetween('created_at', [new Carbon($start_date), new Carbon($end_date)])
                ->where('status', '=', 'Success')
                ->groupBy('month')
                ->orderBy('month', 'DESC')
                ->get();

            $delivery_failure = DB::table('partners_sms')->select(DB::raw('month, sum(sum) as y'))
                ->whereBetween('created_at', [new Carbon($start_date), new Carbon($end_date)])
                ->where('failure_reason', '=', 'DeliveryFailure')
                ->groupBy('month')
                ->orderBy('month', 'DESC')
                ->get();


            $absent_subscriber = DB::table('partners_sms')->select(DB::raw('month, sum(sum) as y'))
                ->whereBetween('created_at', [new Carbon($start_date), new Carbon($end_date)])
                ->whereNotIn('failure_reason', ['', 'DeliveryFailure'])
                ->groupBy('month')
                ->orderBy('month', 'DESC')
                ->get();

        } else if(Auth::user()->user_level == 2) {

            $total_sum = DB::table('partners_sms')->select(DB::raw('sum(sum) as total'))
            ->where('partner_id', Auth::user()->partner_id )
            ->whereBetween('created_at', [new Carbon($start_date), new Carbon($end_date)])
            ->get();

            // pie chart total breakdown
            $breakdown = DB::table('partners_sms')->select(DB::raw('failure_reason, status, sum(sum) as total'))
            ->where('partner_id', Auth::user()->partner_id )
            ->whereBetween('created_at', [new Carbon($start_date), new Carbon($end_date)])
            ->groupBy('status', 'failure_reason')
            ->get();

            $cost = DB::table('partners_sms')->select(DB::raw('month, sum(sum) as total'))
            ->where('partner_id', Auth::user()->partner_id )
            ->whereBetween('created_at', [new Carbon($start_date), new Carbon($end_date)])
            ->orderBy('month', 'DESC')
            ->groupBy('month')
            ->get();

            $success = DB::table('partner_sms_summary')->select(DB::raw('month, sum(sum) as y'))
            ->whereBetween('created_at', [new Carbon($start_date), new Carbon($end_date)])
            ->where('status', '=', 'Success')
            ->where('partner_id', Auth::user()->partner_id )
            ->groupBy('month')
            ->orderBy('month', 'DESC')
            ->get();

            $successNonPartner = [];

            $successPerCounty = [];

            $delivery_failure = DB::table('partners_sms')->select(DB::raw('month, sum(sum) as y'))
                ->whereBetween('created_at', [new Carbon($start_date), new Carbon($end_date)])
                ->where('failure_reason', '=', 'DeliveryFailure')
                ->where('partner_id', Auth::user()->partner_id )
                ->groupBy('month')
                ->orderBy('month', 'DESC')
                ->get();


            $absent_subscriber = DB::table('partners_sms')->select(DB::raw('month, sum(sum) as y'))
                ->whereBetween('created_at', [new Carbon($start_date), new Carbon($end_date)])
                ->where('partner_id', Auth::user()->partner_id )
                ->whereNotIn('failure_reason', ['', 'DeliveryFailure'])
                ->groupBy('month')
                ->orderBy('month', 'DESC')
                ->get();

        }

        $data["delivery_failure"] = $delivery_failure;
        $data["absent_subscriber"] = $absent_subscriber;
        $data["success"] = $success;
        $data["successNonPartner"] = $successNonPartner;
        $data["successPerCounty"] = $successPerCounty;
        $data["cost"] = $cost;
        $data["total_sum"] = $total_sum;
        $data["breakdown"] = $breakdown;

        return $data;

    }
}
