<?php

namespace App\Http\Controllers;

use App\HTSResult;
use Illuminate\Http\Request;

class HTSResultsController extends Controller
{
    public function index(Request $request){

        try{
            $r = new HTSResult;
            $r->nhrl_lab_id = $request->nhrl_lab_id;
            $r->kdod_number = $request->kdod_number;
            $r->sample_id = $request->sample_id;
            $r->age = $request->age;
            $r->gender = $request->gender;
            $r->test = $request->test;
            $r->result_value = $request->result_value;
            $r->status = $request->status;
            $r->component = $request->component;
            $r->mfl_code = $request->mfl_code;
            $r->submit_date = $request->date_submitted;
            $r->date_released = $request->date_released;

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
