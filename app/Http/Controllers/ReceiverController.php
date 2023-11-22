<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReceiverController extends Controller
{
    public function index(Request $request)
    {
        if ($request->to == '40147') {

            $inbox = new Inbox;

            $inbox->shortCode = $request->to;
            $inbox->MSISDN = $request->from;
            $inbox->message = $request->text;
            $inbox->msgDateCreated = $request->date;
            $inbox->message_id = $request->id;
            $inbox->LinkId = $request->linkId;

            $inbox->save();

            $lastID1 = $inbox->id;
            $task = 1;
            $this->task($task, $lastID1);
        }
    }
    function task($task, $LastInsertId)
    {
        Log::info("ID: " . $LastInsertId . ", TASK: " . $task);
        switch ($task) {
            case 1:

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, "http://mlab.localhost/process/inbox/$LastInsertId");
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_exec($ch);

                curl_close($ch);
                echo 'Done task 1';
                break;
            default:
                break;
        }
    }
    public function mlab_callback(Request $request)
    {

        $updateDetails = [
            'status' => $request->get('status'),
            'failure_reason' => $request->get('failureReason')
        ];

        $sms = Outbox::where('messageId', $request->id)->first();
        if ($sms) {
            $sms = Outbox::where('messageId', $request->id)
                ->update($updateDetails);
        }
    }
}
