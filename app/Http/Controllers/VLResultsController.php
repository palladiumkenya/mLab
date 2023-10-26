<?php

namespace App\Http\Controllers;

ini_set('max_execution_time', 0);
ini_set('memory_limit', '1024M');
use Illuminate\Http\Request;
use App\Result;
use App\ILFacility;
use App\Facility;
use App\FacilitySchedule;
use App\Http\Controllers\TasksController as Task;

class VLResultsController extends Controller
{
    public function index(Request $request)
    {
        try {
            $r = new Result;
            $r->source = $request->source;
            $r->result_id = $request->result_id;
            $r->result_type = $request->result_type;
            $r->client_id = $request->client_id;
            $r->age = $request->age;
            $r->request_id = $request->request_id;
            $r->result_content = $request->result_content;
            $r->units = $request->units;
            $r->gender =  $request->gender;
            $r->mfl_code = $request->mfl_code;
            $r->lab_id = $request->lab_id;
            $r->cj = $request->cj;
            $r->cst = $request->cst;
            $r->csr = $request->csr;
            $r->lab_order_date = $request->lab_order_date;
            $r->date_collected = $request->date_collected;

            if ($r->save()) {
                return response(['status' => 'Success']);
            } else {
                return response(['status' => 'Error']);
            }
        } catch (Exception $e) {
            return response(['status' => 'Error']);
        }
    }


    public function getResultlegacy()
    {
       // $ilfs = ILFacility::all();

       //echo 'asdsad';
       $mlab_queue = FacilitySchedule::where('ispulled','<',date('n'))->min('ispulled');
      // $mlab_queue = FacilitySchedule::where('ispulled','<','0')->min('ispulled');


        $mlabfs = FacilitySchedule::where('ispulled',$mlab_queue)
                                    ->limit(50)->get();

        //print_r($mlabfs); exit();

                                    
    // exit();
        if($mlabfs->count()) {
        

        $facilities = array();
        $facilities_ids = array();

        foreach ($mlabfs as $mlabf) {

            $code = $mlabf->mfl_code;
            $legacy_id=$mlabf->id;
            array_push($facilities, $code);
            array_push($facilities_ids, $legacy_id);
        }
       

       
        $results= array_unique($facilities);

     
        $a =  implode(',', $results);
        $update_all =  implode(',', $facilities_ids);


      //echo $a; exit();
      
        //$today = date("Y-m-d");

        //echo date('H');
        //echo  date('h');
        //exit();
        $month=sprintf('%02d', $mlab_queue);
        $month_d=sprintf('%02d', $mlab_queue+1);
        //$yester = date('Y-m-d', strtotime("-31 days"));
        $today = date("Y-m-t", strtotime('2023-'.$month.'-15')); //get the last day of the month
        $yester = '2023-'.$month.'-01'; //start of the month
        //$yester = date('Y-m-d', strtotime("-31 days"));
        //print_r($results);
        //echo $update_all;
        //exit();
        $curl = curl_init();

        // test 1 is VL
        $fields = array(
                'test' => 1,
                'facility_code' =>$a,
               //  'facility_code' =>' $a ',
                'date_dispatched_start' => $yester,
                'date_dispatched_end' => $today
            );
        $fields_string = http_build_query($fields);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://eiddash.nascop.org/api/mlab",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 3000,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER =>0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $fields_string,
            CURLOPT_HTTPHEADER => array(
                "apikey: 11gu6fIIcviGJW4fLq2i"
            ),
            ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo "page: 1".'<br>';
            $objects = json_decode($response);
            
            $data = $objects->data;
            echo "last_page: ".$objects->last_page.'<br>';
        

            foreach ($data as $dat) {
                // check if result already exisits
                $res = Result::where('result_id', $dat->result_id)->where('source', 1)->first();

                //check if ccc has special character or letter or is decimal and replace with nothing
                if (preg_match('#[^0-9]#', $dat->client_id)) {
                    $client_id = preg_replace('/[^a-z0-9 ]+/i','',$dat->client_id);
                } else {
                    $client_id = $dat->client_id;
                }

                if (empty($res)) {
                    $r = new Result;
                    $r->source = $dat->source;
                    $r->result_id = $dat->result_id;
                    $r->result_type = $dat->result_type;
                    $r->client_id = $client_id;
                    $r->age = $dat->age;
                    $r->request_id = $dat->request_id;
                    $r->result_content = $dat->result_content;
                    $r->units = $dat->units;
                    $r->gender =  $dat->gender;
                    $r->mfl_code = $dat->mfl_code;
                    $r->lab_id = $dat->lab_id;
                    $r->cj = $dat->cj;
                    $r->cst = $dat->cst;
                    $r->csr = $dat->csr;
                    $r->lab_order_date = $dat->lab_order_date;
                    $r->date_collected = $dat->date_collected;
                    $r->lab_name = $dat->lab_name;
            
                    if ($r->save()) {
                        $task = new Task;

                        $task->classify($r->id);
                    }
                }
            }

                

            for ($j = 2; $j <= $objects->last_page; $j++) {
                echo "page: ".$j.'<br>';

                $curl = curl_init();

                $fields = array(
                        'test' => 1,
                        'facility_code' => $a,
                        'date_dispatched_start' => $yester,
                        'date_dispatched_end' => $today
            
                    );
                $fields_string = http_build_query($fields);
            
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://eiddash.nascop.org/api/mlab?page=".$j,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 3000,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER =>0,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $fields_string,
                    CURLOPT_HTTPHEADER => array(
                        "apikey: 11gu6fIIcviGJW4fLq2i"
                    ),
                    ));
            
                $response = curl_exec($curl);
                $err = curl_error($curl);
            
                curl_close($curl);
            
                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    $objects = json_decode($response);
                    
                    $data = $objects->data;
            
                    foreach ($data as $dat) {
                        $res = Result::where('result_id', $dat->result_id)->where('source', 1)->first();

                        //check if ccc has special character or letter or is decimal and replace with nothing
                        if (preg_match('#[^0-9]#', $dat->client_id)) {
                            $client_id = preg_replace('/[^a-z0-9 ]+/i','',$dat->client_id);
                        } else {
                            $client_id = $dat->client_id;
                        }

                        if (empty($res)) {
                            $r = new Result;
                            $r->source = $dat->source;
                            $r->result_id = $dat->result_id;
                            $r->result_type = $dat->result_type;
                            $r->client_id = $client_id;
                            $r->age = $dat->age;
                            $r->request_id = $dat->request_id;
                            $r->result_content = $dat->result_content;
                            $r->units = $dat->units;
                            $r->gender =  $dat->gender;
                            $r->mfl_code = $dat->mfl_code;
                            $r->lab_id = $dat->lab_id;
                            $r->cj = $dat->cj;
                            $r->cst = $dat->cst;
                            $r->csr = $dat->csr;
                            $r->lab_order_date = $dat->lab_order_date;
                            $r->date_collected = $dat->date_collected;
                            $r->lab_name = $dat->lab_name;
                    
                            if ($r->save()) {
                                $task = new Task;
        
                                $task->classify($r->id);
                            }
                        }
                    }
                }
            }
        }

        //Update the records of the facilities pulled
        $mlab_queue_one=$mlab_queue+1;
        FacilitySchedule::whereIn('id', $facilities_ids)
          ->update(['ispulled' => $mlab_queue_one]);


    }
    }


    public function getResults()
    {
        $ilfs = ILFacility::all();

        $mlabfs = Facility::whereNotNull('mobile')->whereNotNull('partner_id')->get();

        $facilities = array();

        foreach ($ilfs as $ilf) {
            $code = $ilf->mfl_code;

            array_push($facilities, $code);
        }
        foreach ($mlabfs as $mlabf) {
            $code = $mlabf->code;

            array_push($facilities, $code);
        }
       

       
        $results= array_unique($facilities);

     
        $a =  implode(',', $results);
      
        $today = date("Y-m-d");
        $yester = date('Y-m-d', strtotime("-31 days"));
        $curl = curl_init();

        // test 1 is VL
        $fields = array(
                'test' => 1,
                'facility_code' =>$a,
                'date_dispatched_start' => $yester,
                'date_dispatched_end' => $today

            );
        $fields_string = http_build_query($fields);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://eiddash.nascop.org/api/mlab",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 3000,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER =>0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $fields_string,
            CURLOPT_HTTPHEADER => array(
                "apikey: 11gu6fIIcviGJW4fLq2i"
            ),
            ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo "page: 1".'<br>';
            $objects = json_decode($response);
            
            $data = $objects->data;
            echo "last_page: ".$objects->last_page.'<br>';
        

            foreach ($data as $dat) {
                // check if result already exisits
                $res = Result::where('result_id', $dat->result_id)->where('source', 1)->first();

                //check if ccc has special character or letter or is decimal and replace with nothing
                if (preg_match('#[^0-9]#', $dat->client_id)) {
                    $client_id = preg_replace('/[^a-z0-9 ]+/i','',$dat->client_id);
                } else {
                    $client_id = $dat->client_id;
                }

                if (empty($res)) {
                    $r = new Result;
                    $r->source = $dat->source;
                    $r->result_id = $dat->result_id;
                    $r->result_type = $dat->result_type;
                    $r->client_id = $client_id;
                    $r->age = $dat->age;
                    $r->request_id = $dat->request_id;
                    $r->result_content = $dat->result_content;
                    $r->units = $dat->units;
                    $r->gender =  $dat->gender;
                    $r->mfl_code = $dat->mfl_code;
                    $r->lab_id = $dat->lab_id;
                    $r->cj = $dat->cj;
                    $r->cst = $dat->cst;
                    $r->csr = $dat->csr;
                    $r->lab_order_date = $dat->lab_order_date;
                    $r->date_collected = $dat->date_collected;
                    $r->lab_name = $dat->lab_name;
            
                    if ($r->save()) {
                        $task = new Task;

                        $task->classify($r->id);
                    }
                }
            }

                

            for ($j = 2; $j <= $objects->last_page; $j++) {
                echo "page: ".$j.'<br>';

                $curl = curl_init();

                $fields = array(
                        'test' => 1,
                        'facility_code' => $a,
                        'date_dispatched_start' => $yester,
                        'date_dispatched_end' => $today
            
                    );
                $fields_string = http_build_query($fields);
            
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://eiddash.nascop.org/api/mlab?page=".$j,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 3000,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER =>0,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $fields_string,
                    CURLOPT_HTTPHEADER => array(
                        "apikey: 11gu6fIIcviGJW4fLq2i"
                    ),
                    ));
            
                $response = curl_exec($curl);
                $err = curl_error($curl);
            
                curl_close($curl);
            
                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    $objects = json_decode($response);
                    
                    $data = $objects->data;
            
                    foreach ($data as $dat) {
                        $res = Result::where('result_id', $dat->result_id)->where('source', 1)->first();

                        //check if ccc has special character or letter or is decimal and replace with nothing
                        if (preg_match('#[^0-9]#', $dat->client_id)) {
                            $client_id = preg_replace('/[^a-z0-9 ]+/i','',$dat->client_id);
                        } else {
                            $client_id = $dat->client_id;
                        }

                        if (empty($res)) {
                            $r = new Result;
                            $r->source = $dat->source;
                            $r->result_id = $dat->result_id;
                            $r->result_type = $dat->result_type;
                            $r->client_id = $client_id;
                            $r->age = $dat->age;
                            $r->request_id = $dat->request_id;
                            $r->result_content = $dat->result_content;
                            $r->units = $dat->units;
                            $r->gender =  $dat->gender;
                            $r->mfl_code = $dat->mfl_code;
                            $r->lab_id = $dat->lab_id;
                            $r->cj = $dat->cj;
                            $r->cst = $dat->cst;
                            $r->csr = $dat->csr;
                            $r->lab_order_date = $dat->lab_order_date;
                            $r->date_collected = $dat->date_collected;
                            $r->lab_name = $dat->lab_name;
                    
                            if ($r->save()) {
                                $task = new Task;
        
                                $task->classify($r->id);
                            }
                        }
                    }
                }
            }
        }
    }

    public function getEIDResults()
    {
        //read results from the last month
        $today = date("Y-m-d");
        $yester = date('Y-m-d', strtotime("-31 days"));

        // check for facilities using both app and IL
        $ilfs = ILFacility::all();
        $mlabfs = Facility::whereNotNull('mobile')->whereNotNull('partner_id')->get();




        $facilities = array();

        foreach ($ilfs as $ilf) {
            $code = $ilf->mfl_code;

            array_push($facilities, $code);
        }
        foreach ($mlabfs as $mlabf) {
            $code = $mlabf->code;

            array_push($facilities, $code);
        }
           

       
        $results= array_unique($facilities);

        $a =  implode(',', $results);
        $curl = curl_init();

        // test 2 is eid
        $fields = array(
                'test' => 2,
                'facility_code' =>$a,
                'date_dispatched_start' => $yester,
                'date_dispatched_end' => $today

            );
        $fields_string = http_build_query($fields);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://eiddash.nascop.org/api/mlab",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 3000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $fields_string,
            CURLOPT_HTTPHEADER => array(
                "apikey: 11gu6fIIcviGJW4fLq2i"
            ),
            ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo "page: 1".'<br>';
            $objects = json_decode($response);
            
            $data = $objects->data;
            echo "last_page: ".$objects->last_page.'<br>';

            foreach ($data as $dat) {

                // check if result already exisits
                $res = Result::where('result_id', $dat->result_id)->where('source', 1)->first();

                if (empty($res)) {
                    if ($dat->result_content == '1') {
                        $cnt = "Negative";
                    } elseif ($dat->result_content == '2') {
                        $cnt = "Positive";
                    } else {
                        $cnt = $dat->result_content;
                    }

                    //check if ccc has special character or letter or is decimal and replace with nothing
                    if (preg_match('#[^0-9]#', $dat->client_id)) {
                        $client_id = preg_replace('/[^a-z0-9 ]+/i','',$dat->client_id);
                    } else {
                        $client_id = $dat->client_id;
                    }

                    $r = new Result;
                    $r->source = $dat->source;
                    $r->result_id = $dat->result_id;
                    $r->result_type = $dat->result_type;
                    $r->client_id = $client_id; 
                    $r->age = $dat->age;
                    $r->request_id = $dat->request_id;
                    $r->result_content = $cnt;
                    $r->units = $dat->units;
                    $r->gender =  $dat->gender;
                    $r->mfl_code = $dat->mfl_code;
                    $r->lab_id = $dat->lab_id;
                    $r->cj = $dat->cj;
                    $r->cst = $dat->cst;
                    $r->csr = $dat->csr;
                    $r->lab_order_date = $dat->lab_order_date;
                    $r->date_collected = $dat->date_collected;
                    $r->lab_name = $dat->lab_name;
            
                    if ($r->save()) {
                        $task = new Task;

                        $task->classify($r->id);
                    }
                }
            }

                

            for ($j = 2; $j <= $objects->last_page; $j++) {
                echo "page: ".$j.'<br>';

                $curl = curl_init();

                $fields = array(
                        'test' => 2,
                        'facility_code' =>$a,
                        'date_dispatched_start' => $yester,
                        'date_dispatched_end' => $today
            
                    );
                $fields_string = http_build_query($fields);
            
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://eiddash.nascop.org/api/mlab?page=".$j,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 3000,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $fields_string,
                    CURLOPT_HTTPHEADER => array(
                        "apikey: 11gu6fIIcviGJW4fLq2i"
                    ),
                    ));
            
                $response = curl_exec($curl);
                $err = curl_error($curl);
            
                curl_close($curl);
            
                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    $objects = json_decode($response);
                    
                    $data = $objects->data;
            
                    foreach ($data as $dat) {
                        $res = Result::where('result_id', $dat->result_id)->where('source', 1)->first();
            
                        if (empty($res)) {
                            if ($dat->result_content == '1') {
                                $cnt = "Negative";
                            } elseif ($dat->result_content == '2') {
                                $cnt = "Positive";
                            } else {
                                $cnt = $dat->result_content;
                            }

                            //check if ccc has special character or letter or is decimal and replace with nothing
                            if (preg_match('#[^0-9]#', $dat->client_id)) {
                                $client_id = preg_replace('/[^a-z0-9 ]+/i','',$dat->client_id);
                            } else {
                                $client_id = $dat->client_id;
                            }
            
                            $r = new Result;
                            $r->source = $dat->source;
                            $r->result_id = $dat->result_id;
                            $r->result_type = $dat->result_type;
                            $r->client_id = $client_id; 
                            $r->age = $dat->age;
                            $r->request_id = $dat->request_id;
                            $r->result_content = $cnt;
                            $r->units = $dat->units;
                            $r->gender =  $dat->gender;
                            $r->mfl_code = $dat->mfl_code;
                            $r->lab_id = $dat->lab_id;
                            $r->cj = $dat->cj;
                            $r->cst = $dat->cst;
                            $r->csr = $dat->csr;
                            $r->lab_order_date = $dat->lab_order_date;
                            $r->date_collected = $dat->date_collected;
                            $r->lab_name = $dat->lab_name;
                    
                            if ($r->save()) {
                                $task = new Task;
        
                                $task->classify($r->id);
                            }
                        }
                    }
                }
            }
        }
    }
}
