<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyExchangeRequest;
use Illuminate\Support\Facades\Http;

class ExchangeController extends Controller
{

    public function getData(CurrencyExchangeRequest $request){

        $exchangeRate = 2;
        $reverseExchangeRate = 1;
        $validated = $request->validated();

        // dd($validated);
        return view('home',[
            'amount' => round($validated['amount'] ?? 0,2),
            'baseCurrency' => $validated['baseCurrency'] ?? 'USD',
            'targetedCurrency' => $validated['targetedCurrency'] ?? 'USD',
            'exchangeRate' => $exchangeRate ?? 1,
            'reverseExchangeRate' => $reverseExchangeRate ?? 1,
        ]);
    }


    public function index(CurrencyExchangeRequest $request){

        $baseUrl = config('services.api_service.base_url');
        $apiKey = config('services.api_service.key');

        $validated = $request->validated();

        if(isset($validated['targetedCurrency'])){

            $data = Http::get($baseUrl,[
                'apikey' => $apiKey,
                'currencies' => $validated['targetedCurrency'],
            ]);

            $data = $data->json();
            $reverseExchangeRate = round(1/$data['data'][$validated['targetedCurrency']],2);

            return view('home',[
                'amount' => round($validated['amount'],2),
                'baseCurrency' => $validated['baseCurrency'],
                'targetedCurrency' => $validated['targetedCurrency'],
                'exchangeRate' => $data['data'][$validated['targetedCurrency']],
                'reverseExchangeRate' => $reverseExchangeRate,
            ]);

        } else{
            $data = Http::get($baseUrl,[
                'apikey' => $apiKey,
                'currencies' => 'EUR',
            ]);

            $data = $data->json();
            $reverseExchangeRate = round(1/$data['data']['EUR'],2);

            return view('home',[
                'amount' => 0,
                'baseCurrency' => 'USD',
                'targetedCurrency' => 'EUR',
                'exchangeRate' => $data['data']['EUR'],
                'reverseExchangeRate' => $reverseExchangeRate,
            ]);
        }
    }
}
