<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data;
use App\County;
use App\Partner;
use App\Facility;
use App\SubCounty;

class DataController extends Controller
{
    public function all_results(){
        $results = Data::orderBy('id', 'DESC')->paginate(100);

        return view('data.results')->with('results', $results);
    }

    public function vl_results(){
        $results = Data::orderBy('id', 'DESC')->where('result_type', 'Viral Load')->paginate(100);

        return view('data.results')->with('results', $results);
    }

    public function eid_results(){
        $results = Data::orderBy('id', 'DESC')->where('result_type', 'EID')->paginate(100);

        return view('data.results')->with('results', $results);
    }

    public function rawdataform(){

        $partners = Partner::all();

        $data = array(
            'partners' => $partners,
        );
        return view('data.rawdata')->with($data);
    }


    public function fetchraw(Request $request){

        $data = Data::select('*');
                    if(!empty($request->partner_id)){
                        $partner = Partner::find($request->partner_id);
                        $data->where('partner', $partner->name);
                    }
                    if(!empty($request->county_id)){
                        $county = County::find($request->county_id);
                        $data->where('county', $county->name);
                    }
                    if(!empty($request->sub_county_id)){
                        $subcounty = SubCounty::find($request->sub_county_id);
                        $data->where('sub_county', $subcounty->name);
                    }
                    if(!empty($request->code)){
                        $facility = Facility::where('code', $request->code)->first();
                        $data->where('facility', $facility->name);
                    }
                    if(!empty($request->from)){
                        $data->where('date_sent', '>=', date($request->from));
                    }
                    if(!empty($request->to)){
                        $data->where('date_sent', '<=', date($request->to));
                    }
        

        $results = $data->orderBy('id', 'DESC')->paginate(1000);

        return view('data.raw')->with('results', $results);



    }
}
