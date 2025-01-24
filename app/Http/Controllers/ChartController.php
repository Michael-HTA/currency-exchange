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

        $baseUrl = config('services.api_service.base_url');
        $apiKey = config('services.api_service.key');

         $data = Http::get($baseUrl,[
                'apikey' => $apiKey,
                'currencies' => 'EUR',
            ]);

        return $data;
    }
}
