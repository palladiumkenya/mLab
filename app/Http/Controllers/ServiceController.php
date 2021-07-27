<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;

class serviceController extends Controller
{
    public function index(){
        $services = service::where('status', '!=', 'Deleted')->get();

        return view('services.services')->with('services', $services);
    }

    public function addserviceform(){

        return view('services.addservice');
    }
    public function addservice(Request $request){
        try{
            $service = new service;

            $service->name = $request->name;
            $service->status = 'Active';

            if($service->save()){

                toastr()->success('service has been saved successfully!');

                return redirect()->route('services');
            }else{
                toastr()->error('An error has occurred please try again later.');

                return back();
            }
        }catch(Exception $e){
            toastr()->error('An error has occurred please try again later.');

            return back();
        }


    }

    public function deleteservice(Request $request){
        try{
            $service = service::find($request->pid);

            $service->status = 'Deleted';
            $service->update_at = date('Y-m-d H:i:s');

            if($service->save()){

                return response(['status' => 'success', 'details' => 'service has been deleted successfully']);
            }else{
                return response(['status' => 'error', 'details' => 'An error has occurred please try again later.']);
            }
        }catch(Exception $e){
            return response(['status' => 'error', 'details' => 'An error has occurred please try again later.']);
        }

    }

    public function editservice(Request $request){
        try{
            $service = service::find($request->pid);

            $service->name = $request->name;
            $service->status = $request->status;
            $service->update_at = date('Y-m-d H:i:s');

            if($service->save()){

                toastr()->success('service has been edited successfully!');

                return redirect()->route('services');
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
