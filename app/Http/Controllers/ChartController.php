<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChartController extends Controller
{
    public function index(){
        return view('chart');
    }

    public function get(){
        $data = Http::get('https://api.freecurrencyapi.com/v1/latest?apikey=fca_live_9nYioKrDq09Z6O7cCYxI2ip6rbnYEl4rCStKYxpW&currencies=EUR,CAD');

        return $data;
    }
}
