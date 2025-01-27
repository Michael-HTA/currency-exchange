<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChartController extends Controller
{
    public function index(){
        $currencies = Currency::all();
        $lastSevenDays = ExchangeRate::select('rate')->where('base_id',1)->where('target_id',5)->whereBetween('created_at',[now()->subDays(7), now()])->get();
        // dd($lastSevenDays);
        return view('chart',[
            'currencies' => $currencies,
            'baseCurrency' => 'USD',
            'targetedCurrency' => 'THB',
            'lastSevenDays' => $lastSevenDays,
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
