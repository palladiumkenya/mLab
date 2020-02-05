<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data;
use App\County;
use App\Partner;
use App\Facility;
use App\SubCounty;
use App\HTSData;
use Auth;

class DataController extends Controller
{
    public function all_results()
    {
        $results = Data::orderBy('id', 'DESC');

        if (Auth::user()->user_level == 2) {
            $results->where('partner', Auth::user()->partner->name);
        }
        if (Auth::user()->user_level == 5) {
            $results->where('county', Auth::user()->county->name);
        }
        if (Auth::user()->user_level == 3 || Auth::user()->user_level == 4) {
            $results->where('facility', Auth::user()->facility->name);
        }

        return view('data.results')->with('results', $results->paginate(100));
    }

    public function vl_results()
    {
        $results = Data::orderBy('id', 'DESC')->where('result_type', 'Viral Load');

        if (Auth::user()->user_level == 2) {
            $results->where('partner', Auth::user()->partner->name);
        }
        if (Auth::user()->user_level == 5) {
            $results->where('county', Auth::user()->county->name);
        }
        if (Auth::user()->user_level == 3 || Auth::user()->user_level == 4) {
            $results->where('facility', Auth::user()->facility->name);
        }

        return view('data.results')->with('results', $results->paginate(100));
    }

    public function eid_results()
    {
        $results = Data::orderBy('id', 'DESC')->where('result_type', 'EID');

        if (Auth::user()->user_level == 2) {
            $results->where('partner', Auth::user()->partner->name);
        }
        if (Auth::user()->user_level == 5) {
            $results->where('county', Auth::user()->county->name);
        }
        if (Auth::user()->user_level == 3 || Auth::user()->user_level == 4) {
            $results->where('facility', Auth::user()->facility->name);
        }

        return view('data.results')->with('results', $results->paginate(100));
    }

    public function hts_results()
    {
        $results = HTSData::orderBy('hts_result_id', 'DESC');

        if (Auth::user()->user_level == 2) {
            $results->where('partner', Auth::user()->partner->name);
        }
        if (Auth::user()->user_level == 5) {
            $results->where('county', Auth::user()->county->name);
        }
        if (Auth::user()->user_level == 3 || Auth::user()->user_level == 4) {
            $results->where('facility', Auth::user()->facility->name);
        }

        return view('data.hts_results')->with('results', $results->paginate(100));
    }

    public function rawdataform()
    {
        $partners = Partner::all();
        

        $data = array(
            'partners' => $partners,
        );
        return view('data.rawdata')->with($data);
    }


    public function fetchraw(Request $request)
    {
        $data = Data::select('*');
        if (!empty($request->partner_id)) {
            $partner = Partner::find($request->partner_id);
            $data->where('partner', $partner->name);
        }
        if (!empty($request->county_id)) {
            $county = County::find($request->county_id);
            $data->where('county', $county->name);
        }
        if (!empty($request->sub_county_id)) {
            $subcounty = SubCounty::find($request->sub_county_id);
            $data->where('sub_county', $subcounty->name);
        }
        if (!empty($request->code)) {
            $facility = Facility::where('code', $request->code)->first();
            $data->where('facility', $facility->name);
        }
        if (!empty($request->from)) {
            $data->where('date_sent', '>=', date($request->from));
        }
        if (!empty($request->to)) {
            $data->where('date_sent', '<=', date($request->to));
        }
        if (Auth::user()->user_level == 2) {
            $data->where('partner', Auth::user()->partner->name);
        }
        

        $results = $data->orderBy('id', 'DESC')->paginate(1000);

        return view('data.raw')->with('results', $results);
    }
}
