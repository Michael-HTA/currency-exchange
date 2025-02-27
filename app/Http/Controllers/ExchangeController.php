<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyExchangeRequest;
use App\Models\Currency;
use Illuminate\Support\Facades\Http;

class ExchangeController extends Controller
{
    public function getData(CurrencyExchangeRequest $request){

        $exchangeRate = 2;
        $reverseExchangeRate = 1;
        $validated = $request->validated();
        $currencies = Currency::all();


        // dd($validated);
        return view('home',[
            'currencies' => $currencies,
            'amount' => round($validated['amount'] ?? 0,2),
            'baseCurrency' => $validated['baseCurrency'] ?? 'USD',
            'targetedCurrency' => $validated['targetedCurrency'] ?? 'THB',
            'exchangeRate' => $exchangeRate ?? 1,
            'reverseExchangeRate' => $reverseExchangeRate ?? 1,
        ]);
    }


    public function index(CurrencyExchangeRequest $request){

        $baseUrl = config('services.api_service.base_url');
        $apiKey = config('services.api_service.key');

        $validated = $request->validated();
        $currencies = Currency::all();

        if(isset($validated['targetedCurrency'])){

            $data = Http::get($baseUrl . 'latest',[
                'apikey' => $apiKey,
                'currencies' => $validated['targetedCurrency'],
            ]);

            $data = $data->json();
            $reverseExchangeRate = round(1/$data['data'][$validated['targetedCurrency']],2);

            return view('home',[
                'currencies' => $currencies,
                'amount' => round($validated['amount'],2),
                'baseCurrency' => $validated['baseCurrency'],
                'targetedCurrency' => $validated['targetedCurrency'],
                'exchangeRate' => round($data['data'][$validated['targetedCurrency']],2),
                'reverseExchangeRate' => $reverseExchangeRate,
            ]);

        } else{

            $data = Http::get($baseUrl .'latest',[
                'apikey' => $apiKey,
                'currencies' => 'THB',
            ]);

            $data = $data->json();
            // dd($data);
            $reverseExchangeRate = round(1/$data['data']['THB'],2);

            return view('home',[
                'currencies' => $currencies,
                'amount' => 10,
                'baseCurrency' => 'USD',
                'targetedCurrency' => 'THB',
                'exchangeRate' => round($data['data']['THB'],2),
                'reverseExchangeRate' => $reverseExchangeRate,
            ]);
        }
    }
}
