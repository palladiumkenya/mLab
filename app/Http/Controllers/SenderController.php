<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AfricasTalking\SDK\AfricasTalking;
use App\Sender;
use Redirect;

class SenderController extends Controller
{
    public function send($to, $message)
    {
        $username = "mhealthkenya";
        $apiKey = Config::get('services.at.key');
        $AT       = new AfricasTalking($username, $apiKey);

        // Get one of the services
        $sms      = $AT->sms();
        // Use the service
        $send   = $sms->send([
                        'from' => '40147',
                        'to'      => $to,
                        'message' => $message
                    ]);


        if ($send) {
            $sent = new Sender;
            $sent->number = $to;
            $sent->message = $message;
            foreach ($send['data'] as $data) {
                $dts = $data->Recipients;
                foreach ($dts as $dt) {
                    date_default_timezone_set('UTC');
                    $date = date('Y-m-d H:i:s', time());

                    $sent->status = $dt->status;
                    $sent->statusCode = $dt->statusCode;
                    $sent->messageId = $dt->messageId;
                    $sent->cost = $dt->cost;
                    $sent->updated_at = $date;
                    $sent->created_at = $date;
                }
            }
            $sent->save();
            return Redirect::back()->with($send);
        }
        return Redirect::back();
    }
}
