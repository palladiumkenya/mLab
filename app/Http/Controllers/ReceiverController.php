<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inbox;

class ReceiverController extends Controller
{
    public function index(Request $request){

        $inb = new Inbox;

        $inb->shortCode = $request->to;
        $inb->MSISDN = $request->from; 
        $inb->message = $request->text;
        $inb->msgDateCreated = $request->date;
        $inb->message_id = $request->id;
        $inb->LinkId = $request->linkId;

        $inb->save();

    }
}
