<?php

namespace App\Http\Controllers;
use App\TBResult;
use Illuminate\Http\Request;

class TBResultsController extends Controller
{
    public function index(Request $request){

        try{
            $r = new TBResult;
            $r->sample_id = $request->sample_id;
            $r->kdod_number = $request->kdod_number;
            $r->age = $request->age;
            $r->gender = $request->gender;
            $r->test1 = $request->test1;
            $r->result_value1 = $request->result_value1;
            $r->test2 = $request->test2;
            $r->result_value2 = $request->result_value2;
            $r->test3 =  $request->test3;
            $r->result_value3 = $request->result_value3;
            $r->mfl_code = $request->mfl_code;
            $r->login_date = $request->login_date;
            $r->date_reviewed = $request->date_reviewed;
            $r->record_date = $request->record_date;
            $r->testing_lab = $request->testing_lab;

            if($r->save()){

                return response(['status' => 'Success']);
            }
            else{
                return response(['status' => 'Error']);
            }

        } catch (Exception $e) {
            return response(['status' => 'Error']);
        }

      

    }
}
