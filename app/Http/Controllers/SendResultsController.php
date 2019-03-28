<?php

namespace App\Http\Controllers;
ini_set('max_execution_time', 0);
ini_set('memory_limit', '1024M');
use Illuminate\Http\Request;
use App\Http\Controllers\SenderController;
use App\Result;
use App\Facility;
use App\ILFacility;
use App\HTSResult;
use App\TBResult;

class SendResultsController extends Controller
{
    public function sendVLEID(Request $request){

        $facility = Facility::where('mobile', $request->phone_no)->first();

        if(!empty($facility)){
            $mfl = $facility->code;

            $results = Result::whereNull('date_sent')->where('processed', '0')->where('mfl_code', $mfl)->get();

        
            foreach ($results as $result){

                $id = $result->id;
                $type = $result->result_type;
                $client_id = $result->client_id;
                $age = $result->age;
                $gender = $result->gender;
                $content = $result->result_content;
                $units = $result->units;
                $date_collected = $result->date_collected;
                $mfl = $result->mfl_code;


                if (strpos($date_collected, "00:00:00") !== false) {
                    $date_collected = substr($date_collected, 0, 10);
                }
                
                if ($type == 1) {
                    $ftype = "VL";
                    $rtype = "FFViral Load Results";
                } 
                elseif ($type == 2) {
                    $ftype = "EID";
                    $rtype = "FFEID Results";
                }

                $facility = Facility::where('code', $mfl)->first();

                $dest = $facility->mobile;
                $msgmlb = "$ftype PID:$client_id A:$age S:$gender DC:$date_collected R: :$content $units";
            
                $encr =  base64_encode($msgmlb);
                $finalmsg = "<#> ". $encr . " ukmLMZrTc2e";

                date_default_timezone_set('Africa/Nairobi');
                $date = date('Y-m-d H:i:s', time());

                $sender = new SenderController;
                if($sender->send($dest, $finalmsg)){

                    $result->processed = '1';
                    $result->date_sent = $date;
                    $result->date_delivered = $date;
                    $result->updated_at = $date;


                    $result->save();

                }
                

            }
        }else{
            $sender = new SenderController;
            $sender->send($request->phone_no, "Phone Number not attched to any Facility");

        }

    }

    public function sendIL(){

        $facilities = ILFacility::all();

        $ilfs = [];

        foreach ($facilities as $facility){

            array_push($ilfs, $facility->mfl_code);

        }

        $results = Result::whereIn('mfl_code', $ilfs)->where('il_send', '0')->get();

        foreach($results as $result){

            $id = $result->id;
            $type = $result->result_type;
            $client_id = $result->client_id;
            $lab = $result->lab_id;
            $age = $result->age;
            $gender = $result->gender;
            $content = $result->result_content;
            $units = $result->units;
            $date_collected = $result->date_collected;
            $mfl = $result->mfl_code;
            $csr = $result->csr;
            $cst = $result->cst;
            $cj = $result->cj;
            $date_ordered = $result->lab_order_date;

            if (strpos($date_collected, "00:00:00") !== false) {
                $date_collected = substr($date_collected, 0, 10);
            }
            if (strpos($date_ordered, "00:00:00") !== false) {
                $date_ordered = substr($date_ordered, 0, 10);
            }
            

            if ($type = 1) {
                $rtype = "VL";
                $msg = "ID: $id, PID:$client_id, Age:$age, Sex:$gender, DC:$date_collected, LOD: $date_ordered, CSR: $csr, CST: $cst, CJ: $cj, Result: :$content $units, MFL: $mfl, Lab: $lab";

                $ted =  base64_encode($msg);
                
                $encr = "IL ". $ted;
            }

            $nf = ILFacility::where('mfl_code', $mfl)->where('phone_no', 'not like', '%SWOP%')->first();

            if(!empty($nf)){
                $dest = $nf->phone_no;

                $date = date('Y-m-d H:i:s', time());

                $sender = new SenderController;
                if($sender->send($dest, $encr)){

                    $result->il_send = '1';
                    $result->date_sent = $date;
                    $result->date_delivered = $date;
                    $result->updated_at = $date;


                    $result->save();

                }
            }
        }

    }

    public function sendHTS(){

        $results = HTSResult::where('processed', '0')->get();

        foreach($results as $result){
            $pid = $result->patient_id;
            $age = $result->age;
            $gender = $result->gender;
            $test = $result->test;
            $res = $result->result_value;
            $sub = $result->submit_date;
            $rel = $result->date_released;
            $mfl = $result->mfl_code;

            if (strpos($rel, "00:00:00") !== false) {
                $rel = substr($rel, 0, 10);
            }
            if (strpos($sub, "00:00:00") !== false) {
                $sub = substr($sub, 0, 10);
            }
            
            
            $facility = Facility::where('code', $mfl)->first();

            $dest = $facility->mobile;
            $msgmlb = "HTS PID:$pid A:$age S:$gender T:$test R:$res SB: $sub REL:$rel";

            $encr =  base64_encode($msgmlb);

            date_default_timezone_set('Africa/Nairobi');
            $date = date('Y-m-d H:i:s', time());

            $sender = new SenderController;
            if($sender->send($dest, $encr)){

                $result->processed = '1';
                $result->date_sent = $date;
                $result->date_delivered = $date;
                $result->updated_at = $date;


                $result->save();

            }
        }

    }

    public function sendTB(){

        $results = TBResult::where('processed', '0')->get();

        foreach($results as $result){
            $pid = $result->patient_id;
            $age = $result->age;
            $gender = $result->gender;
            $res1 = $result->result_value1;
            $res2 = $result->result_value2;
            $res3 = $result->result_value3;
            $login_date = $result->login_date;
            $date_reviewed = $result->date_reviewed;
            $record_date = $result->record_date;
            $mfl = $result->mfl_code;


            if (strpos($login_date, "00:00:00") !== false) {
                $login_date = substr($login_date, 0, 10);
            }
            if (strpos($date_reviewed, "00:00:00") !== false) {
                $date_reviewed = substr($date_reviewed, 0, 10);
            }
            if (strpos($record_date, "00:00:00") !== false) {
                $record_date = substr($record_date, 0, 10);
            }
            

            $facility = Facility::where('code', $mfl)->first();

            $dest = $facility->mobile;
            $msgmlb = "TB PID:$pid A:$age S:$gender SC:$res1 MC:$res2 LJC:$res3 LD: $login_date DR:$date_reviewed RD:$record_date";

            echo $msgmlb;
            exit;

            $encr =  base64_encode($msgmlb);

            date_default_timezone_set('Africa/Nairobi');
            $date = date('Y-m-d H:i:s', time());

            $sender = new SenderController;
            if($sender->send($dest, $encr)){

                $result->processed = '1';
                $result->date_sent = $date;
                $result->date_delivered = $date;
                $result->updated_at = $date;


                $result->save();

            }
        }

    }

    public function ViralLoads(Request $request)
    {

        $results = Result::where('mfl_code', $request->mfl_code)->where('result_type', 1)
        // ->where('il_send', 0)
        ->limit(10)->get();

        $final = [];
        
        foreach($results as $res){
            
            $time = date("YmdHis");

            $header = (object)[
                "SENDING_APPLICATION" => "MLAB",
                "SENDING_FACILITY" => "",
                "RECEIVING_APPLICATION" => "*",
                "RECEIVING_FACILITY" => $request->mfl_code,
                "MESSAGE_DATETIME" =>$time,
                "SECURITY" => "",
                "MESSAGE_TYPE" => "ORU^VL",
                "PROCESSING_ID" => "P"

            ];

            $internalIdentifiers = [
                (object)[
                    "ID" => $res->client_id,
                    "IDENTIFIER_TYPE" => "CCC_NUMBER",
                    "ASSIGNING_AUTHORITY" => "CCC"
                ]
            ];

            $patientIdentifier = (object)[
                "INTERNAL_PATIENT_ID" => $internalIdentifiers
            ];


            $result = [
                (object)[
                    "DATE_SAMPLE_COLLECTED" =>  date('YmdHis',strtotime($res->date_collected)),
                    "DATE_LAB_ORDERED" => date('YmdHis',strtotime($res->date_collected)),
                    "DATE_SAMPLE_TESTED" => "",
                    "VL_RESULT" => $res->result_content.' '.$res->units,
                    "SAMPLE_TYPE" => $res->cst,
                    "SAMPLE_REJECTION" => $res->csr,
                    "JUSTIFICATION" => $res->cj,
                    "REGIMEN" => "",
                    "LAB_TESTED_IN" => $res->lab_id
                ]
            ];
        

            $full = (object)[
                "MESSAGE_HEADER" => $header,
                "PATIENT_IDENTIFICATION" => $patientIdentifier,                
                "VIRAL_LOAD_RESULT" => $result
            ];
            
            array_push($final, $full);

            $res->il_send = 1;

            $res->save();
        }


        return response()->json(["results" => $final], 200);
    }
}
