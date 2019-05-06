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
    public function results(Request $request){
        $phone = base64_decode($request->phone);
        $msg = base64_decode($request->message);


        $fac = Facility::where('mobile', $phone)->first();
      
        if(!empty($fac)){
            $val = explode("*", $msg);

            

            if($val[0] == 'VL'){
                if(sizeof($val) < 12){
                    echo "Kindly ensure all fields are included";
                    
               }else{

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

                if($rl->save()){
                    echo "Sample Remote Login Successful";
                }else{
                    echo "An error occured, kindly try again";
                }
            }

            }elseif($val[0] == 'EID'){
                if(sizeof($val) < 15){
                    echo "Kindly ensure all fields are included";
                    
               }else{
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

                if($rl->save()){
                    echo "Sample Remote Login Successful";
                }else{
                    echo "An error occured, kindly try again";
                }
            }

            }

            
        }else{
            echo "Phone Number not Authorised to send remote samples";
        }

  

    }

    public function hts(Request $request){
        $phone = base64_decode($request->phone);
        $msg = base64_decode($request->message);


        $fac = Facility::where('mobile', $phone)->first();

        if(!empty($fac)){
            $val = explode("*", $msg);

            if(sizeof($val) < 18){
                echo "Kindly ensure all fields are included";
                
           }else{

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


                if($rl->save()){
                    echo "Sample Remote Login Successful";
                }else{
                    echo "An error occured, kindly try again";
                }
            }
         
        }else{
            echo "Phone Number not Authorised to send remote samples";
        }

  

    }
}
