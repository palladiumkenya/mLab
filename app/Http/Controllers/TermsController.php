<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Http\Controllers\SenderController;

class TermController extends Controller
{
    public function index()
    {
        return view('data.terms');
    }
}