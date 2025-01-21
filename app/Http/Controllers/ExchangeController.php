<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyExchangeRequest;
use Illuminate\Support\Facades\Http;

class ExchangeController extends Controller
{

    public function index(CurrencyExchangeRequest $request){

        $exchangeRate = 2;
        $reverseExchangeRate = 1;
        $validated = $request->validated();

        // dd($validated);
        return view('home',[
            'amount' => $validated['amount'] ?? 0,
            'baseCurrency' => $validated['baseCurrency'] ?? 'USD',
            'targetedCurrency' => $validated['targetedCurrency'] ?? 'USD',
            'exchangeRate' => $exchangeRate ?? 1,
            'reverseExchangeRate' => $reverseExchangeRate ?? 1,
        ]);
    }
    public function getData(CurrencyExchangeRequest $request){

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
