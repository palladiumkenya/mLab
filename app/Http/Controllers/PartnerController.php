<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Partner;

class PartnerController extends Controller
{
    public function index(){
        $partners = Partner::where('status', '!=', 'Deleted')->get();

        return view('partners.partners')->with('partners', $partners);
    }

    public function addpartnerform(){

        return view('partners.addpartner');
    }
    public function addpartner(Request $request){
        try{
            $partner = new Partner;

            $partner->name = $request->name;
            $partner->status = 'Active';

            if($partner->save()){

                toastr()->success('Partner has been saved successfully!');

                return redirect()->route('partners');
            }else{
                toastr()->error('An error has occurred please try again later.');

                return back();
            }
        }catch(Exception $e){
            toastr()->error('An error has occurred please try again later.');

            return back();
        }


    }

    public function deletepartner(Request $request){
        try{
            $partner = Partner::find($request->pid);

            $partner->status = 'Deleted';
            $partner->update_at = date('Y-m-d H:i:s');

            if($partner->save()){

                return response(['status' => 'success', 'details' => 'Partner has been deleted successfully']);
            }else{
                return response(['status' => 'error', 'details' => 'An error has occurred please try again later.']);
            }
        }catch(Exception $e){
            return response(['status' => 'error', 'details' => 'An error has occurred please try again later.']);
        }

    }

    public function editpartner(Request $request){
        try{
            $partner = Partner::find($request->pid);

            $partner->name = $request->name;
            $partner->status = $request->status;
            $partner->update_at = date('Y-m-d H:i:s');

            if($partner->save()){

                toastr()->success('Partner has been edited successfully!');

                return redirect()->route('partners');
            }else{
                toastr()->error('An error has occurred please try again later.');

                return back();
            }
        }catch(Exception $e){
            toastr()->error('An error has occurred please try again later.');

            return back();
        }

    }
}
