<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facility;
use App\ILFacility;
use App\County;
use Auth;

class FacilityController extends Controller
{
    public function index(){

        $facilities = Facility::with('sub_county.county','partner')->whereNotNull('mobile')->whereNotNull('partner_id');
        
        if(Auth::user()->user_level == 2){
            $facilities->where('partner_id', Auth::user()->partner_id);
        }
        if(Auth::user()->user_level == 5){
            $facilities->join('sub_county','sub_county.id', '=', 'health_facilities.Sub_County_ID')->where('sub_county.county_id', Auth::user()->county_id);
        }

        return view('facility.facility')->with('facilities', $facilities->get());
    }

    public function addfacilityform(){
        $counties = County::all();
        $data = array(
            'counties' => $counties,
        );

        return view('facility.addfacility')->with($data);
    }

    public function addfacility(Request $request){
        try{
            $facility = Facility::where('code', $request->code)->first();
            $facility->mobile = $request->phone;
            $facility->partner_id = Auth::user()->partner->id;
            $facility->updated_at = date('Y-m-d H:i:s');

            if($facility->save()){

                toastr()->success('Facility has been added successfully!');

                return redirect()->route('facilities');
            }else{
                toastr()->error('An error has occurred please try again later.');

                return back();
            }
        }catch(Exception $e){
            toastr()->error('An error has occurred please try again later.');

            return back();
        }

    }

    public function edit_facility(Request $request){

        try{
            $facility = Facility::where('code', $request->code)->first();

            $facility->mobile = $request->phone;
            $facility->updated_at = date('Y-m-d H:i:s');


            if($facility->save()){

                toastr()->success('Facility has been edited successfully!');

                return redirect()->route('facilities');
            }else{
                toastr()->error('An error has occurred please try again later.');

                return back();
            }
        }catch(Exception $e){
            toastr()->error('An error has occurred please try again later.');

            return back();
        }
    }

    public function removefacility(Request $request){

        try{
            $facility = Facility::find($request->id);

            $facility->mobile = null;
            $facility->partner_id = null;
            $facility->updated_at = date('Y-m-d H:i:s');
            
            if($facility->save()){

                return response(['status' => 'success', 'details' => 'Facility has been removed successfully']);
            }else{
                return response(['status' => 'error', 'details' => 'An error has occurred please try again later.']);
            }
        }catch(Exception $e){
            return response(['status' => 'error', 'details' => 'An error has occurred please try again later.']);
        }
    }
    

    public function active_facilities(){

        $data = [];
        $facilities = Facility::whereNotNull('mobile')->get();

        $ilfs = ILFacility::all();

        foreach($ilfs as $ilf){

            $fac = [];

            $code = $ilf->mfl_code;

            $facility = Facility::where('code', $code)->first();

            $fac['facility'] = $facility->name;
            $fac['mfl_code'] = $facility->code;
            $fac['date_added'] = $ilf->created_at;


            array_push($data, $fac);

            
        }

        foreach($facilities as $f){
            $fa = [];

            $fa['facility'] = $f->name;
            $fa['mfl_code'] = $f->code;
            $fa['date_added'] = $f->modified;

            array_push($data, $fa);



        }

        $a = array_unique(array($data));
        

        echo json_encode($a);
    }
}
