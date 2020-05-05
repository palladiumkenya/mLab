<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\SmsGateway;
use AfricasTalking\SDK\AfricasTalking;

date_default_timezone_set('Africa/Nairobi');
ini_set('max_execution_time', 0);
ini_set('memory_limit', '1024M');

class SmsGatewayController extends Controller
{
    public function sender(Request $request)
    {
        $username = "mhealthuser";
        $apiKey = "1f6943f6c8f0d5d6b0dd54cd940935bdec8f7454c4e7863672048dae496ae355";
        $AT       = new AfricasTalking($username, $apiKey);
         
        $phone = $request->phone_no;
        $message = $request->message;
        // Get one of the services
        $sms      = $AT->sms();
        // Use the service
        $send   = $sms->send([
                        'from' => '40146',
                        'to'      => $phone,
                        'message' => $message
                    ]);

        if ($send) {
            foreach ($send['data'] as $data) {
                $dts = $data->Recipients;
                foreach ($dts as $dt) {
                    $smsgtw = new SmsGateway;
                    $smsgtw->user_id = Auth::user()->id;
                    $smsgtw->phone_no = $phone;
                    $smsgtw->message = $message;
                    $smsgtw->delivery_status = $dt->status;
                    $smsgtw->cost = $dt->cost;

                    if ($smsgtw->save()) {
                        return response()->json(["message_status" => $dt->status, "Cost" => $dt->cost], 200);
                    }
                }
            }
        } else {
            return response()->json(["results" => "Error Sending message, please try again"], 400);
        }
    }
}
