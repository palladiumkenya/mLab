<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unit;
use App\Program;

class UnitController extends Controller
{
    public function index(){
        $units = Unit::where('status', '!=', 'Deleted')->get();

         return view('units.units')->with('units', $units);

    }

    public function addunitform(){

        $programs = Program::all();

        $data = array(
            'programs' => $programs,
        );

        return view('units.addunit')->with($data);

    }

    public function addunit(Request $request){
        try{
            $unit = new Unit;

            $unit->name = $request->name;
            $unit->program_id = $request->program_id;
            $unit->status = 'Active';

            if($unit->save()) {

                toastr()->success('Unit has been saved successfully!');

                return redirect()->route('units');

            } else {

                toastr()->error('An error occurred please try again later.');

                return back();
            }
        }catch(Exception $e){

            toastr()->error('An error has occured please try again later.');

            return back();
        }
    }

    public function editunit(Request $request){
        try{

            $unit = Unit::find($request->uid);

            $unit->name = $request->name;
            $unit->name = $request->program;
            $unit->status = $request->status; 
            $unit->updated_at = date('Y-m-d H:i:s');

            if($unit->save()){

                toastr()->success('Unit has been deleted successfully.');

                return redirect()->route('units');

            } else {

                toastr()->error('An error has occurred please try again later.');

                return back();

            }
        } catch(Exception $e) {

                toastr()->error('An error has occured please try again later. ');

                return back();
        }

      
    }

    public function deleteunit(Request $request){
        try{

            $unit = Unit::find($request->uid);

            $unit->status = 'Deleted';
            $unit->updated_at = date('Y-m-d H:i:s');

            if($unit->save()){

                return response(['status' => 'success', 'details' => 'Unit has been deleted successfully']);

            } else {

                return response(['status' => 'error', 'details' => 'An error has occurred please try again later']);

            }

        }catch(Exception $e){

            return response(['status' => 'error', 'details' => 'An error has occurred please try again later']);

        }
    }
}
