<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\SmsGateway;
use AfricasTalking\SDK\AfricasTalking;

class SmsGatewayController extends Controller
{
    public function sender(Request $request)
    {
        $username = "mhealthkenya";
        $apiKey = "9318d173cb9841f09c73bdd117b3c7ce3e6d1fd559d3ca5f547ff2608b6f3212";
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
