<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Program;

class ProgramController extends Controller
{
    public function index(){
        $programs = Program::where('status', '!=', 'Deleted')->get();

        return view('programs.programs')->with('programs', $programs);
    }

    public function addprogramform(){

        return view('programs.addprogram');
    }
    public function addprogram(Request $request){
        try{
            $program = new Program;

            $program->name = $request->name;
            $program->status = 'Active';

            if($program->save()){

                toastr()->success('program has been saved successfully!');

                return redirect()->route('programs');
            }else{
                toastr()->error('An error has occurred please try again later.');

                return back();
            }
        }catch(Exception $e){
            toastr()->error('An error has occurred please try again later.');

            return back();
        }


    }

    public function deleteprogram(Request $request){
        try{
            $program = Program::find($request->pid);

            $program->status = 'Deleted';
            $program->update_at = date('Y-m-d H:i:s');

            if($program->save()){

                return response(['status' => 'success', 'details' => 'program has been deleted successfully']);
            }else{
                return response(['status' => 'error', 'details' => 'An error has occurred please try again later.']);
            }
        }catch(Exception $e){
            return response(['status' => 'error', 'details' => 'An error has occurred please try again later.']);
        }

    }

    public function editprogram(Request $request){
        try{
            $program = Program::find($request->pid);

            $program->name = $request->name;
            $program->status = $request->status;
            $program->update_at = date('Y-m-d H:i:s');

            if($program->save()){

                toastr()->success('program has been edited successfully!');

                return redirect()->route('programs');
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
