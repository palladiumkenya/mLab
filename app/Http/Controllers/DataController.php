<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data;
use App\County;
use App\Partner;

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
        $counties = County::all();

        $data = array(
            'counties' => $counties,
            'partners' => $partners,
        );
        return view('data.rawdata')->with($data);
    }
}
