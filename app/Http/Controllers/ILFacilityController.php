<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ILFacility;
use App\County;
use App\SubCounty;
use App\Facility;

class ILFacilityController extends Controller
{
    public function index()
    {
        $facilities = ILFacility::with('facility.sub_county.county')->get();

        return view('facility.il_facility')->with('facilities', $facilities);
    }

    public function addilfacilityform()
    {
        $counties = County::all();
        $data = array(
            'counties' => $counties,
        );

        return view('facility.addilfacility')->with($data);
    }

    public function addilfacility(Request $request)
    {
        try {
            $facility = new ILFacility;

            $facility->mfl_code = $request->code;
            if (!empty($request->phone)) {
                $facility->phone_no = $request->phone;
            } else {
                $facility->phone_no = $request->code;
            }
            if(!empty($request->internet) {
                $facility->internet = $request->internet;
            } else {
                $facility->internet = 'Yes';
            }

            if ($facility->save()) {
                toastr()->success('IL Facility has been saved successfully!');

                return redirect()->route('il_facilities');
            } else {
                toastr()->error('An error has occurred please try again later.');

                return back();
            }
        } catch (Exception $e) {
            toastr()->error('An error has occurred please try again later.');

            return back();
        }
    }

    public function edit_ilfacility(Request $request)
    {
        try {
            $facility = ILFacility::where('mfl_code', $request->code)->first();

            $facility->phone_no = $request->phone;
            $facility->updated_at = date('Y-m-d H:i:s');


            if ($facility->save()) {
                toastr()->success('IL Facility has been edited successfully!');

                return redirect()->route('il_facilities');
            } else {
                toastr()->error('An error has occurred please try again later.');

                return back();
            }
        } catch (Exception $e) {
            toastr()->error('An error has occurred please try again later.');

            return back();
        }
    }

    public function delete_ilfacility(Request $request)
    {
        try {
            $facility = ILFacility::where('mfl_code', $request->code)->delete();

            if ($facility) {
                return response(['status' => 'success', 'details' => 'Facility has been deleted successfully']);
            } else {
                return response(['status' => 'error', 'details' => 'An error has occurred please try again later.']);
            }
        } catch (Exception $e) {
            return response(['status' => 'error', 'details' => 'An error has occurred please try again later.']);
        }
    }
}
