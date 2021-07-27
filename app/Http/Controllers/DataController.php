<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data;
use App\County;
use App\Service;
use App\Facility;
use App\SubCounty;
use App\HTSData;
use App\SRLEIData;
use App\SRLHTSData;
use App\SRLVLData;
use App\Unit;
use Auth;

class DataController extends Controller
{
    public function all_results()
    {
        $results = Data::orderBy('id', 'DESC');

        if (Auth::user()->user_level == 2) {
            $results->where('service', Auth::user()->service->name);
        }
        if (Auth::user()->user_level == 5) {
            $results->where('unit', Auth::user()->unit->name);
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
            $results->where('service', Auth::user()->service->name);
        }
        if (Auth::user()->user_level == 5) {
            $results->where('unit', Auth::user()->unit->name);
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
            $results->where('service', Auth::user()->service->name);
        }
        if (Auth::user()->user_level == 5) {
            $results->where('unit', Auth::user()->unit->name);
        }
        if (Auth::user()->user_level == 3 || Auth::user()->user_level == 4) {
            $results->where('facility', Auth::user()->facility->name);
        }

        return view('data.results')->with('results', $results->paginate(100));
    }

    public function serviceform()
    {
        $services = service::all();

        $data = array(
            'services' => $services,
        );
        return view('data.hts_filter')->with($data);
    }

    public function hts_results(Request $request)
    {
        $results = HTSData::select('*');
        if (!empty($request->service_id)) {
            $service = service::find($request->service_id);
            $results->where('service', $service->name);
        }
        if (!empty($request->unit_id)) {
            $unit = Unit::find($request->unit_id);
            $data->where('unit', $unit->name);
        }
        if (!empty($request->county_id)) {
            $county = County::find($request->county_id);
            $results->where('county', $county->name);
        }
        if (!empty($request->sub_county_id)) {
            $subcounty = SubCounty::find($request->sub_county_id);
            $results->where('sub_county', $subcounty->name);
        }
        if (!empty($request->code)) {
            $facility = Facility::where('code', $request->code)->first();
            $results->where('facility', $facility->name);
        }
        if (!empty($request->from)) {
            $results->where('date_sent', '>=', date($request->from));
        }
        if (!empty($request->to)) {
            $results->where('date_sent', '<=', date($request->to));
        }

        if (Auth::user()->user_level == 2) {
            $results->where('service', Auth::user()->service->name);
        }

        return view('data.hts_results')->with('results', $results->paginate(100));
    }

    public function rawdataform()
    {
        $services = service::all();
        

        $data = array(
            'services' => $services,
        );
        return view('data.rawdata')->with($data);
    }

    public function fetchraw(Request $request)
    {
        $data = Data::select('*');
        if (!empty($request->service_id)) {
            $service = service::find($request->service_id);
            $data->where('service', $service->name);
        }
        if (!empty($request->unit_id)) {
            $unit = Unit::find($request->unit_id);
            $data->where('unit', $unit->name);
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
            $data->where('service', Auth::user()->service->name);
        }
        

        $results = $data->orderBy('id', 'DESC')->paginate(1000);

        return view('data.raw')->with('results', $results);
    }

    public function vl_srl_form()
    {
        $services = service::all();
        

        $data = array(
            'services' => $services,
        );
        return view('data.vl_srl_filter')->with($data);
    }

    public function vl_srl_results(Request $request)
    {
        $results = SRLVLData::select('*');
        if (!empty($request->service_id)) {
            $service = service::find($request->service_id);
            $results->where('service', $service->name);
        }
        if (!empty($request->unit_id)) {
            $unit = Unit::find($request->unit_id);
            $results->where('unit', $unit->name);
        }
        if (!empty($request->county_id)) {
            $county = County::find($request->county_id);
            $results->where('county', $county->name);
        }
        if (!empty($request->sub_county_id)) {
            $sub_county = SubCounty::find($request->sub_county_id);
            $results->where('sub_county', $sub_county->name);
        }
        if (!empty($request->code)) {
            $facility = Facility::where('code', $request->code)->first();
            $results->where('facility', $facility->name);
        }
        if (!empty($request->lab_name)) {
            $results->where('lab_name', $request->lab_name);
        }
        if (!empty($request->selected_type)) {
            $results->where('selected_type', $request->selected_type);
        }
        if (!empty($request->from)) {
            $results->where('created_at', '>=', date($request->from));
        }
        if (!empty($request->to)) {
            $results->where('created_at', '<=', date($request->to));
        }

        if (Auth::user()->user_level == 2) {
            $results->where('service', Auth::user()->service->name);
        }
        if (Auth::user()->user_level == 5) {
            $results->where('county', Auth::user()->county->name);
        }
        if (Auth::user()->user_level == 3 || Auth::user()->user_level == 4) {
            $results->where('facility', Auth::user()->facility->code);
        }

        return view('data.vl_srl_results')->with('results', $results->paginate(100));
    }

    public function eid_srl_form()
    {
        $services = service::all();
        

        $data = array(
            'services' => $services,
        );
        return view('data.eid_srl_filter')->with($data);
    }


    public function eid_srl_results(Request $request)
    {

        $results = SRLEIData::select('*');
        if (!empty($request->service_id)) {
            $service = service::find($request->service_id);
            $results->where('service', $service->name);
        }
        if (!empty($request->unit_id)) {
            $unit = Unit::find($request->unit_id);
            $results->where('unit', $unit->name);
        }
        if (!empty($request->county_id)) {
            $county = County::find($request->county_id);
            $results->where('county', $county->name);
        }
        if (!empty($request->sub_county_id)) {
            $sub_county = SubCounty::find($request->sub_county_id);
            $results->where('sub_county', $sub_county->name);
        }
        if (!empty($request->code)) {
            $facility = Facility::where('code', $request->code)->first();
            $results->where('facility', $facility->name);
        }
        if (!empty($request->lab_name)) {
            $results->where('lab_name', $request->lab_name);
        }
        if (!empty($request->entry_point)) {
            $results->where('entry_point', $request->entry_point);
        }
        if (!empty($request->from)) {
            $results->where('created_at', '>=', date($request->from));
        }
        if (!empty($request->to)) {
            $results->where('created_at', '<=', date($request->to));
        }

        if (Auth::user()->user_level == 2) {
            $results->where('service', Auth::user()->service->name);
        }
        if (Auth::user()->user_level == 5) {
            $results->where('county', Auth::user()->county->name);
        }
        if (Auth::user()->user_level == 3 || Auth::user()->user_level == 4) {
            $results->where('facility', Auth::user()->facility->code);
        }

        $results->orderBy('id', 'DESC')->paginate(1000);

        return view('data.eid_srl_results')->with('results', $results->paginate(100));
    }

    
    public function hts_srl_form()
    {
        $services = service::all();
        

        $data = array(
            'services' => $services,
        );
        return view('data.hts_srl_filter')->with($data);
    }


    public function hts_srl_results(Request $request)
    {
        $results = SRLHTSData::select('*');
        if (!empty($request->service_id)) {
            $service = service::find($request->service_id);
            $results->where('service', $service->name);
        }
        if (!empty($request->unit_id)) {
            $unit = Unit::find($request->unit_id);
            $results->where('unit', $unit->name);
        }
        if (!empty($request->county_id)) {
            $county = County::find($request->county_id);
            $results->where('county', $county->name);
        }
        if (!empty($request->sub_county_id)) {
            $sub_county = SubCounty::find($request->sub_county_id);
            $results->where('sub_county', $sub_county->name);
        }
        if (!empty($request->code)) {
            $facility = Facility::where('code', $request->code)->first();
            $results->where('facility', $facility->name);
        }
        if (!empty($request->lab_name)) {
            $results->where('lab_name', $request->lab_name);
        }
        if (!empty($request->selected_delivery_point)) {
            $results->where('selected_delivery_point', $request->selected_delivery_point);
        }
        if (!empty($request->from)) {
            $results->where('created_at', '>=', date($request->from));
        }
        if (!empty($request->to)) {
            $results->where('created_at', '<=', date($request->to));
        }

        if (Auth::user()->user_level == 2) {
            $results->where('service', Auth::user()->service->name);
        }
        if (Auth::user()->user_level == 5) {
            $results->where('county', Auth::user()->county->name);
        }
        if (Auth::user()->user_level == 3 || Auth::user()->user_level == 4) {
            $results->where('facility', Auth::user()->facility->code);
        }

        $results->orderBy('id', 'DESC')->paginate(1000);

        return view('data.hts_srl_results')->with('results', $results->paginate(100));
    }
}
