<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth; 

class HomeController extends Controller
{
    public function index()
    {
        Auth::user()->load('partner', 'facility', 'county');

        return view('dashboard.dashboardv1');
       
    }
}
