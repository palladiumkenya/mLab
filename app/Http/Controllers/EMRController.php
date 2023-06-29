<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Result;
use App\Partner;
use App\Facility;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Http\Controllers\SenderController;

class EMRController extends Controller
{
    public function index()
    {
        $partners = Partner::all();
        

        $data = array(
            'partners' => $partners,
        );
        return view('data.clients_filter')->with($data);
    }

    public function getResults(Request $request)
    {
        $mfl = $request->mfl_code;


     if(($request->from=='') && ($request->to=='') )
     {
        $from_date = date('Y-m-d', strtotime('1990-01-01')); // default date in the past

        $to_date = date('Y-m-d'); // current date


     }else{

        $from_date = Carbon::parse($request->from);
        $to_date = Carbon::parse($request->to);

     }

     $result_type=1; //VL results Type

   if (!empty($mfl)) {
            $results = Result::where('mfl_code', $mfl)
                     ->where('result_type', $result_type)
                    ->whereDate('date_collected','>=',$from_date)
                    ->whereDate('date_collected','<=',$to_date)
                    ->select('results.client_id as ccc_no',
                    'results.age as age',
                    'results.gender as gender',
                    'results.result_content as result_content',
                    'results.units as units',
                    'results.mfl_code',
                    'results.date_collected',
                    'results.lab_order_date',
                    'results.lab_name')
                    ->paginate(1000);
                    //->get();
           
     
            if (!$results->isEmpty()) {
                return response()->json(['message' => 'success', 'results' => $results], 200);
            } else {
                return response()->json(['message' => 'No results for the given MFL code were found'], 200);
            }
    } else {
            return response()->json(['message' => 'Kindly specify MFL Code'], 400);
    }
    }

}
