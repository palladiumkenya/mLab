<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facility;
use Carbon\Carbon;
use App\SRLVLs;
use App\SRLEIDs;
use App\SRLHTS;

class RemoteLoginController extends Controller
{
    public function results(Request $request)
    {
        $phone = base64_decode($request->phone);
        $msg = base64_decode($request->message);


        $fac = Facility::where('mobile', $phone)->first();
      
        if (!empty($fac)) {
            $val = explode("*", $msg);

            

            if ($val[0] == 'VL') {
                if (sizeof($val) < 12) {
                    return response()->json(['Kindly ensure all fields are included'], 500);
                } else {
                    $ccc = $val[1];
                    $patient_name = $val[2];
                    $dob = $val[3];
                    $date_collected = $val[4];
                    $art_start = $val[5];
                    $current_regimen = $val[6];
                    $date_art_regimen = $val[7];
                    $art_line = $val[8];
                    $just_code = $val[9];
                    $selected_type = $val[10];
                    $selected_sex = $val[11];
                    $lab_id = $val[16];
                    $lab_name = $val[17];

                    $dob =  Carbon::parse(str_replace('/', '-', $dob))->format('Y-m-d');
                    $date_collected =  Carbon::parse(str_replace('/', '-', $date_collected))->format('Y-m-d');
                    $art_start =  Carbon::parse(str_replace('/', '-', $art_start))->format('Y-m-d');
                    $date_art_regimen =  Carbon::parse(str_replace('/', '-', $date_art_regimen))->format('Y-m-d');

                    $rl = new SRLVLs;

                    $rl->ccc_num = $ccc;
                    $rl->patient_name = $patient_name;
                    $rl->dob = $dob;
                    $rl->date_collected = $date_collected;
                    $rl->art_start_date =$art_start;
                    $rl->current_regimen = $current_regimen;
                    $rl->date_art_regimen = $date_art_regimen;
                    $rl->art_line = $art_line;
                    $rl->justification_code = $just_code;
                    $rl->selected_type = $selected_type;
                    $rl->selected_sex = $selected_sex;
                    $rl->facility = $fac->code;
                    $r1->lab_name = $lab_name;


                    if ($rl->save()) {
                        return response()->json(['Sample Remote Login Successful'], 201);
                    } else {
                        return response()->json(['An error occured, kindly try again'], 500);
                    }
                }
            } elseif ($val[0] == 'EID') {
                if (sizeof($val) < 15) {
                    return response()->json(['Kindly ensure all fields are included'], 500);
                } else {
                    $selected_sex = $val[1];
                    $selected_regimen= $val[2];
                    $selected_alive = $val[3];
                    $hein_number = $val[4];
                    $patient_name = $val[5];
                    $dob = $val[6];
                    $entry_point = $val[7];
                    $date_collected = $val[8];
                    $prophylaxis_code = $val[9];
                    $infant_feeding = $val[10];
                    $pcr = $val[11];
                    $alive_dead = $val[12];
                    $mother_age = $val[13];
                    $haart_date = $val[14];
                    $lab_id = $val[19];
                    $lab_name = $val[20];

                    $dob =  Carbon::parse(str_replace('/', '-', $dob))->format('Y-m-d');
                    $date_collected =  Carbon::parse(str_replace('/', '-', $date_collected))->format('Y-m-d');
                    $haart_date =  Carbon::parse(str_replace('/', '-', $haart_date))->format('Y-m-d');

                    $rl = new SRLEIDs;

                    $rl->selected_sex = $selected_sex;
                    $rl->selected_regimen = $selected_regimen;
                    $rl->dob = $dob;
                    $rl->selected_alive = $selected_alive;
                    $rl->hein_number =$hein_number;
                    $rl->patient_name = $patient_name;
                    $rl->entry_point = $entry_point;
                    $rl->date_collected = $date_collected;
                    $rl->prophylaxis_code = $prophylaxis_code;
                    $rl->infant_feeding = $infant_feeding;
                    $rl->pcr = $pcr;
                    $rl->alive_dead = $alive_dead;
                    $rl->mother_age = $mother_age;
                    $rl->haart_date = $haart_date;
                    $rl->facility = $fac->code;
                    $r1->lab_id = $lab_id;
                    $r1->lab_name = $lab_name;


                    if ($rl->save()) {
                        return response()->json(['Sample Remote Login Successful'], 201);
                    } else {
                        return response()->json(['An error occured, kindly try again'], 500);
                    }
                }
            }
        } else {
            return response()->json(['Phone Number not Authorised to send remote samples'], 500);
        }
    }

    public function hts(Request $request)
    {
        $phone = base64_decode($request->phone);
        $msg = base64_decode($request->message);


        $fac = Facility::where('mobile', $phone)->first();

        if (!empty($fac)) {
            $val = explode("*", $msg);

            if (sizeof($val) < 18) {
                return response()->json(['Kindly ensure all fields are included'], 500);
            } else {
                $sample_number = $val[0];
                $client_name = $val[1];
                $dob = $val[2];
                $selected_sex = $val[3];
                $telephone = $val[4];
                $test_date = $val[5];
                $selected_delivery_point = $val[6];
                $selected_test_kit_1 = $val[7];
                $lot_number_1 = $val[8];
                $expiry_date_1 = $val[9];
                $selectec_test_kit_2 = $val[10];
                $lot_number_2 = $val[11];
                $expiry_date_2 = $val[12];
                $selected_final_result = $val[13];
                $sample_tester_name = $val[14];
                $dbs_date = $val[15];
                $dbs_dispatch_date = $val[16];
                $requesting_provider = $val[17];
                $lab_id= $val[22];
                $lab_name = $val[23];

                $dob =  Carbon::parse(str_replace('/', '-', $dob))->format('Y-m-d');
                $test_date =  Carbon::parse(str_replace('/', '-', $test_date))->format('Y-m-d');
                $expiry_date_1 =  Carbon::parse(str_replace('/', '-', $expiry_date_1))->format('Y-m-d');
                $expiry_date_2 =  Carbon::parse(str_replace('/', '-', $expiry_date_2))->format('Y-m-d');
                $dbs_date =  Carbon::parse(str_replace('/', '-', $dbs_date))->format('Y-m-d');
                $dbs_dispatch_date =  Carbon::parse(str_replace('/', '-', $dbs_dispatch_date))->format('Y-m-d');

                $rl = new SRLHTS;

                $rl->sample_number = $sample_number;
                $rl->client_name = $client_name;
                $rl->dob = $dob;
                $rl->selected_sex = $selected_sex;
                $rl->telephone = $telephone;
                $rl->test_date =$test_date;
                $rl->selected_delivery_point = $selected_delivery_point;
                $rl->selected_test_kit1 = $selected_test_kit_1;
                $rl->lot_number1 = $lot_number_1;
                $rl->expiry_date1 = $expiry_date_1;
                $rl->selected_test_kit2 = $selectec_test_kit_2;
                $rl->lot_number2 = $lot_number_2;
                $rl->expiry_date2 = $expiry_date_2;
                $rl->selected_final_result = $selected_final_result;
                $rl->sample_tester_name = $sample_tester_name;
                $rl->dbs_date = $dbs_date;
                $rl->dbs_dispatch_date = $dbs_dispatch_date;
                $rl->requesting_provider = $requesting_provider;
                $rl->facility = $fac->code;
                $r1->lab_id = $lab_id;
                $r1->lab_name = $lab_name;


                if ($rl->save()) {
                    return response()->json(['Sample Remote Login Successful'], 201);
                } else {
                    return response()->json(['An error occured, kindly try again'], 500);
                }
            }
        } else {
            return response()->json(['Phone Number not Authorised to send remote samples'], 500);
        }
    }

    public function SendVLsLab()
    {
        $remote_vls = SRLVLs::where('processed', 0)->limit(10)->get();
        foreach ($remote_vls as $remote_vl) {
            if ($remote_vl->selected_sex == 'Female') {
                $sex = 2;
            } elseif ($remote_vl->selected_sex == 'Male') {
                $sex = 1;
            } else {
                $sex = 3;
            }

            $data = 'mflCode='.$remote_vl->facility.'&patient_identifier='.$remote_vl->ccc_num.'&dob='.$remote_vl->dob.
                '&datecollected='.$remote_vl->date_collected.'&sex='.$sex.'&sampletype=1&justification='.$remote_vl->justification_code.
                '&pmtct=3&prophylaxis=AF2A';

            if($remote_vl->lab_name === 'Kemri Nairobi') {

                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://kemrinairobi.nascop.org/api/",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/x-www-form-urlencoded",
                    "apikey" => Config::get('services.srl.key'),
                ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                $phpArray = json_decode($response,true);
                $batch_full = $phpArray['batch']['batch_full'] ; 

                if(!empty($response->batch_id)) {
                    $remote_vl->processed = 1;
                    $remote_vl->save();
                }

                if($batch_full === 1) {

                    $msg = "Hello ".$remote_vl->facility.", We would like to inform you that the samples entered have been captured under batch no # ".$response->batch_id." ";

                    $to = DB::table('health_facilities')
                    ->where('code', '=', $remote_vl->facility )
                    ->pluck('mobile')->first(); 

                    $sender = new SenderController;
                    $sender->send($to, $msg);

                }

                echo $response;

            }  else if($remote_vl->lab_name === 'KEMRI Kisumu') {

                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://kemrikisumu.nascop.org/api/",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/x-www-form-urlencoded",
                    "apikey" => Config::get('services.srl.key'),
                ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                $phpArray = json_decode($response,true);
                $batch_full = $phpArray['batch']['batch_full'] ; 

                if(!empty($response->batch_id)) {
                    $remote_vl->processed = 1;
                    $remote_vl->save();
                }

                if($batch_full === 1) {

                    $msg = "Hello ".$remote_vl->facility.", We would like to inform you that the samples entered have been captured under batch no # ".$response->batch_id." ";

                    $to = DB::table('health_facilities')
                    ->where('code', '=', $remote_vl->facility )
                    ->pluck('mobile')->first(); 

                    $sender = new SenderController;
                    $sender->send($to, $msg);

                }

                echo $response;

            }  else if($remote_vl->lab_name === 'KEMRI Alupe') {

                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://kemrialupe.nascop.org/api/",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/x-www-form-urlencoded",
                    "apikey" => Config::get('services.srl.key'),
                ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                $phpArray = json_decode($response,true);
                $batch_full = $phpArray['batch']['batch_full'] ; 

                if(!empty($response->batch_id)) {
                    $remote_vl->processed = 1;
                    $remote_vl->save();
                }

                if($batch_full === 1) {

                    $msg = "Hello ".$remote_vl->facility.", We would like to inform you that the samples entered have been captured under batch no # ".$response->batch_id." ";

                    $to = DB::table('health_facilities')
                    ->where('code', '=', $remote_vl->facility )
                    ->pluck('mobile')->first(); 

                    $sender = new SenderController;
                    $sender->send($to, $msg);

                }

                echo $response;
                
            }  else if($remote_vl->lab_name === 'Walter Reed') {

                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://wrpkericho.nascop.org/api/",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/x-www-form-urlencoded",
                    "apikey" => Config::get('services.srl.key'),
                ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                $phpArray = json_decode($response,true);
                $batch_full = $phpArray['batch']['batch_full'] ; 

                if(!empty($response->batch_id)) {
                    $remote_vl->processed = 1;
                    $remote_vl->save();
                }

                if($batch_full === 1) {

                    $msg = "Hello ".$remote_vl->facility.", We would like to inform you that the samples entered have been captured under batch no # ".$response->batch_id." ";

                    $to = DB::table('health_facilities')
                    ->where('code', '=', $remote_vl->facility )
                    ->pluck('mobile')->first(); 

                    $sender = new SenderController;
                    $sender->send($to, $msg);

                }

                echo $response;
                
            }  else if($remote_vl->lab_name === 'Ampath MTRH') {

                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://ampath.nascop.org/api/",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/x-www-form-urlencoded",
                    "apikey" => Config::get('services.srl.key'),
                ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                $phpArray = json_decode($response,true);
                $batch_full = $phpArray['batch']['batch_full'] ; 

                if(!empty($response->batch_id)) {
                    $remote_vl->processed = 1;
                    $remote_vl->save();
                }

                if($batch_full === 1) {

                    $msg = "Hello ".$remote_vl->facility.", We would like to inform you that the samples entered have been captured under batch no # ".$response->batch_id." ";

                    $to = DB::table('health_facilities')
                    ->where('code', '=', $remote_vl->facility )
                    ->pluck('mobile')->first(); 

                    $sender = new SenderController;
                    $sender->send($to, $msg);

                }

                echo $response;
                
            }  else if($remote_vl->lab_name === 'Coast lab') {

                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => "http://lab.test.nascop.org/api/vl",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/x-www-form-urlencoded",
                    "apikey" => Config::get('services.srl.key'),
                ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                $phpArray = json_decode($response,true);
                $batch_full = $phpArray['batch']['batch_full'] ; 

                if(!empty($response->batch_id)) {
                    $remote_vl->processed = 1;
                    $remote_vl->save();
                }

                if($batch_full === 1) {

                    $msg = "Hello ".$remote_vl->facility.", We would like to inform you that the samples entered have been captured under batch no # ".$response->batch_id." ";

                    $to = DB::table('health_facilities')
                    ->where('code', '=', $remote_vl->facility )
                    ->pluck('mobile')->first(); 

                    $sender = new SenderController;
                    $sender->send($to, $msg);

                }

                echo $response;
                
            }  else if($remote_vl->lab_name === 'KNH') {
                
                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://knh.nascop.org/api",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/x-www-form-urlencoded",
                    "apikey" => Config::get('services.srl.key'),
                ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                $phpArray = json_decode($response,true);
                $batch_full = $phpArray['batch']['batch_full'] ; 

                if(!empty($response->batch_id)) {
                    $remote_vl->processed = 1;
                    $remote_vl->save();
                }

                if($batch_full === 1) {

                    $msg = "Hello ".$remote_vl->facility.", We would like to inform you that the samples entered have been captured under batch no # ".$response->batch_id." ";

                    $to = DB::table('health_facilities')
                    ->where('code', '=', $remote_vl->facility )
                    ->pluck('mobile')->first(); 

                    $sender = new SenderController;
                    $sender->send($to, $msg);

                }

                echo $response;
            }  else if($remote_vl->lab_name === 'KU Teaching and Referring Hospital') {
                
                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://kutrrh.nascop.org/api",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/x-www-form-urlencoded",
                    "apikey" => Config::get('services.srl.key'),
                ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                $phpArray = json_decode($response,true);
                $batch_full = $phpArray['batch']['batch_full'] ; 

                if(!empty($response->batch_id)) {
                    $remote_vl->processed = 1;
                    $remote_vl->save();
                }

                if($batch_full === 1) {

                    $msg = "Hello ".$remote_vl->facility.", We would like to inform you that the samples entered have been captured under batch no # ".$response->batch_id." ";

                    $to = DB::table('health_facilities')
                    ->where('code', '=', $remote_vl->facility )
                    ->pluck('mobile')->first(); 

                    $sender = new SenderController;
                    $sender->send($to, $msg);

                }

                echo $response;
            }  
            
        }
    }

    public function SendEIDLab()
    {
        $remote_eids = SRLEIDs::where('processed', 0)->limit(10)->get();
        foreach ($remote_eids as $remote_eid) {
            if ($remote_eid->selected_sex == 'Female') {
                $sex = 2;
            } elseif ($remote_eid->selected_sex == 'Male') {
                $sex = 1;
            } else {
                $sex = 3;
            }

            // entry point must be integer
            // add lab in payload as integer
            // add regimen as integer
            // pcr type should be integer

            $data = 'mflCode='.$remote_eid->facility.'&patient_identifier='.$remote_eid->hein_number.'&dob='.$remote_eid->dob.
                '&datecollected='.$remote_eid->date_collected.'&sex='.$sex.'&feeding='.$remote_eid->infant_feeding.'&pcrtype=1'.
                '&regimen=16&entry_point='.$remote_eid->entry_point.'&mother_prophylaxis=21&mother_age='.$remote_eid->mother_age.'&lab='.$remote_eid->lab_id. '' ; 

                if($remote_eid->lab_name === 'Kemri Nairobi') {

                    $curl = curl_init();
    
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://kemrinairobi.nascop.org/api/",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $data,
                    CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/x-www-form-urlencoded",
                        "apikey" => Config::get('services.srl.key'),
                    ),
                    ));
    
                    $response = curl_exec($curl);
    
                    curl_close($curl);

                    $phpArray = json_decode($response,true);
                    $batch_full = $phpArray['batch']['batch_full'] ; 
    
                    if(!empty($response->batch_id)) {
                        $remote_vl->processed = 1;
                        $remote_vl->save();
                    }
    
                    if($batch_full === 1) {
    
                        $msg = "Hello ".$remote_vl->facility.", We would like to inform you that the samples entered have been captured under batch no # ".$response->batch_id." ";
    
                        $to = DB::table('health_facilities')
                        ->where('code', '=', $remote_eid->facility )
                        ->pluck('mobile')->first(); 
    
                        $sender = new SenderController;
                        $sender->send($to, $msg);
    
                    }
    
                    echo $response;
    
                }  else if($remote_eid->lab_name === 'KEMRI Kisumu') {
    
                    $curl = curl_init();
    
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://kemrikisumu.nascop.org/api/",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $data,
                    CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/x-www-form-urlencoded",
                        "apikey" => Config::get('services.srl.key'),
                    ),
                    ));
    
                    $response = curl_exec($curl);
    
                    curl_close($curl);
    
                                $phpArray = json_decode($response,true);
                    $batch_full = $phpArray['batch']['batch_full'] ; 

                    if(!empty($response->batch_id)) {
                        $remote_vl->processed = 1;
                        $remote_vl->save();
                    }

                    if($batch_full === 1) {

                    $msg = "Hello ".$remote_vl->facility.", We would like to inform you that the samples entered have been captured under batch no # ".$response->batch_id." ";
    
                        $to = DB::table('health_facilities')
                        ->where('code', '=', $remote_eid->facility )
                        ->pluck('mobile')->first(); 
    
                        $sender = new SenderController;
                        $sender->send($to, $msg);
    
                    }
    
                    echo $response;
    
                }  else if($remote_eid->lab_name === 'KEMRI Alupe') {
    
                    $curl = curl_init();
    
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://kemrialupe.nascop.org/api/",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $data,
                    CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/x-www-form-urlencoded",
                        "apikey" => Config::get('services.srl.key'),
                    ),
                    ));
    
                    $response = curl_exec($curl);
    
                    curl_close($curl);
    
                    $phpArray = json_decode($response,true);
                    $batch_full = $phpArray['batch']['batch_full'] ; 
    
                    if(!empty($response->batch_id)) {
                        $remote_vl->processed = 1;
                        $remote_vl->save();
                    }
    
                    if($batch_full === 1) {
    
                        $msg = "Hello ".$remote_vl->facility.", We would like to inform you that the samples entered have been captured under batch no # ".$response->batch_id." ";
    
                        $to = DB::table('health_facilities')
                        ->where('code', '=', $remote_eid->facility )
                        ->pluck('mobile')->first(); 
    
                        $sender = new SenderController;
                        $sender->send($to, $msg);
    
                    }
    
                    echo $response;
                    
                }  else if($remote_eid->lab_name === 'Walter Reed') {
    
                    $curl = curl_init();
    
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://wrpkericho.nascop.org/api/",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $data,
                    CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/x-www-form-urlencoded",
                        "apikey" => Config::get('services.srl.key'),
                    ),
                    ));
    
                    $response = curl_exec($curl);
    
                    curl_close($curl);
    
                    $phpArray = json_decode($response,true);
                    $batch_full = $phpArray['batch']['batch_full'] ; 
    
                    if(!empty($response->batch_id)) {
                        $remote_vl->processed = 1;
                        $remote_vl->save();
                    }
    
                    if($batch_full === 1) {
    
                        $msg = "Hello ".$remote_vl->facility.", We would like to inform you that the samples entered have been captured under batch no # ".$response->batch_id." ";
    
                        $to = DB::table('health_facilities')
                        ->where('code', '=', $remote_eid->facility )
                        ->pluck('mobile')->first(); 
    
                        $sender = new SenderController;
                        $sender->send($to, $msg);
    
                    }
    
                    echo $response;
                    
                }  else if($remote_eid->lab_name === 'Ampath MTRH') {
    
                    $curl = curl_init();
    
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://ampath.nascop.org/api/",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $data,
                    CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/x-www-form-urlencoded",
                        "apikey" => Config::get('services.srl.key'),
                    ),
                    ));
    
                    $response = curl_exec($curl);
    
                    curl_close($curl);
    
                    $phpArray = json_decode($response,true);
                    $batch_full = $phpArray['batch']['batch_full'] ; 
    
                    if(!empty($response->batch_id)) {
                        $remote_vl->processed = 1;
                        $remote_vl->save();
                    }
    
                    if($batch_full === 1) {
    
                        $msg = "Hello ".$remote_vl->facility.", We would like to inform you that the samples entered have been captured under batch no # ".$response->batch_id." ";
    
                        $to = DB::table('health_facilities')
                        ->where('code', '=', $remote_eid->facility )
                        ->pluck('mobile')->first(); 
    
                        $sender = new SenderController;
                        $sender->send($to, $msg);
    
                    }
    
                    echo $response;
                    
                }  else if($remote_eid->lab_name === 'Coast lab') {
    
                    $curl = curl_init();
    
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => "http://lab.test.nascop.org/api/vl",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $data,
                    CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/x-www-form-urlencoded",
                        "apikey" => Config::get('services.srl.key'),
                    ),
                    ));
    
                    $response = curl_exec($curl);
    
                    curl_close($curl);

                    $phpArray = json_decode($response,true);
                    $batch_full = $phpArray['batch']['batch_full'] ; 
    
                    if(!empty($response->batch_id)) {
                        $remote_vl->processed = 1;
                        $remote_vl->save();
                    }
    
                    if($batch_full === 1) {
    
                        $msg = "Hello ".$remote_vl->facility.", We would like to inform you that the samples entered have been captured under batch no # ".$response->batch_id." ";
    
                        $to = DB::table('health_facilities')
                        ->where('code', '=', $remote_eid->facility )
                        ->pluck('mobile')->first(); 
    
                        $sender = new SenderController;
                        $sender->send($to, $msg);
    
                    }
    
                    echo $response;
                    
                }  else if($remote_eid->lab_name === 'KNH') {
                    
                    $curl = curl_init();
    
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://knh.nascop.org/api",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $data,
                    CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/x-www-form-urlencoded",
                        "apikey" => Config::get('services.srl.key'),
                    ),
                    ));
    
                    $response = curl_exec($curl);
    
                    curl_close($curl);

                    $phpArray = json_decode($response,true);
                    $batch_full = $phpArray['batch']['batch_full'] ; 
    
                    if(!empty($response->batch_id)) {
                        $remote_vl->processed = 1;
                        $remote_vl->save();
                    }
    
                    if($batch_full === 1) {
    
                        $msg = "Hello ".$remote_vl->facility.", We would like to inform you that the samples entered have been captured under batch no # ".$response->batch_id." ";
    
                        $to = DB::table('health_facilities')
                        ->where('code', '=', $remote_eid->facility )
                        ->pluck('mobile')->first(); 
    
                        $sender = new SenderController;
                        $sender->send($to, $msg);
    
                    }
    
                    echo $response;

                }  else if($remote_eid->lab_name === 'KU Teaching and Referring Hospital') {
                    
                    $curl = curl_init();
    
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://kutrrh.nascop.org/api",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $data,
                    CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/x-www-form-urlencoded",
                        "apikey" => Config::get('services.srl.key'),
                    ),
                    ));
    
                    $response = curl_exec($curl);
    
                    curl_close($curl);
    
                    $phpArray = json_decode($response,true);
                    $batch_full = $phpArray['batch']['batch_full'] ; 

                    if(!empty($response->batch_id)) {
                        $remote_vl->processed = 1;
                        $remote_vl->save();
                    }

                    if($batch_full === 1) {

                    $msg = "Hello ".$remote_vl->facility.", We would like to inform you that the samples entered have been captured under batch no # ".$response->batch_id." ";

                        $sender = new SenderController;
                        $sender->send($to, $msg);

                    }
    
                    echo $response;

                }  
        }
    }

    public function SendHTSLab()
    {
        $remote_htss = SRLHTS::where('processed', 0)->limit(10)->get();
        foreach ($remote_htss as $remote_hts) {
            if ($remote_hts->selected_sex == 'Female') {
                $sex = 2;
            } elseif ($remote_hts->selected_sex == 'Male') {
                $sex = 1;
            } else {
                $sex = 3;
            }

            // entry point must be integer
            // add lab in payload as integer
            // add regimen as integer
            // pcr type should be integer

            $data = 'mflCode='.$remote_hts->facility.'&patient_identifier='.$remote_hts->hein_number.'&dob='.$remote_hts->dob.
                '&datecollected='.$remote_hts->date_collected.'&sex='.$sex.'&feeding='.$remote_hts->infant_feeding.'&pcrtype=1'.
                '&regimen=16&entry_point='.$remote_hts->entry_point.'&mother_prophylaxis=21&mother_age='.$remote_hts->mother_age.'&lab=3';

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://lab.test.nascop.org/api/eid',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                  'Content-Type: application/x-www-form-urlencoded',
                  'apikey' => Config::get('services.srl.key'),
                ),
              ));

            $response = curl_exec($curl);

            curl_close($curl);

            if($response->status_code === 201) {
                $remote_hts->processed = 1;
                $remote_hts->save();
            }

            echo $response;
        }
    }

}
