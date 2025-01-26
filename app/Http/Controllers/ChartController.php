<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChartController extends Controller
{
    public function index(){
        $currencies = Currency::all();

        return view('chart',[
            'currencies' => $currencies,
        ]);
    }

    public function get(){

        $baseUrl = config('services.api_service.base_url');
        $apiKey = config('services.api_service.key');

         $data = Http::get($baseUrl,[
                'apikey' => $apiKey,
                'currencies' => 'EUR',
            ]);

        return $data;
    }
}
