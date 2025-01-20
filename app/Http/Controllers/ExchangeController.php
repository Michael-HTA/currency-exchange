<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyExchangeRequest;
use Illuminate\Support\Facades\Http;

class ExchangeController extends Controller
{
    public function index(CurrencyExchangeRequest $request){

        $baseUrl = config('services.api_service.base_url');
        $apiKey = config('services.api_service.key');

        $validated = $request->validated();

        if(isset($validated['targeted_currency'])){

            return Http::get($baseUrl,[
                'apikey' => $apiKey,
                'currencies' => $validated['targeted_currency'],
            ]);
        } else{
            return Http::get($baseUrl,[
                'apikey' => $apiKey,
                'currencies' => 'EUR',
            ]);
        }
    }
}
