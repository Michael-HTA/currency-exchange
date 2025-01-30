<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChartRequest;
use App\Models\Currency;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ChartController extends Controller
{
    public function index()
    {

        $currencies = Currency::where('code', '!=', 'USD')->get();


        $lastSevenDays = $this->getLastSevenDaysData(2);

        $lastSevenDaysName = [];
        for ($i = 1; $i < 7; $i++) {
            $date = Carbon::now()->subDays($i);
            $lastSevenDaysName[] = $date->format('l');
        }
        // dd($lastSevenDaysName);

        return view('chart', [
            'currencies' => $currencies,
            'baseCurrency' => 'USD',
            'targetedCurrency' => 'THB',
            'lastSevenDays' => $lastSevenDays,
            'lastSevenDaysName' => $lastSevenDaysName,
        ]);
    }

    public function getChartData(ChartRequest $request)
    {
        $validated = $request->validated();

        $currency = Currency::where('code', $validated['targetedCurrency'])->first();

        return response()->json([
            'data' => $this->getLastSevenDaysData($currency->id),
            'targetedCurrency' => $currency->name,
        ], 200);
    }

    private function getLastSevenDaysData($targetId)
    {

        return ExchangeRate::select('rate')->where('base_id', 1)->where('target_id', $targetId)->whereBetween('created_at', [now()->subDays(7), now()]) ->orderBy('created_at', 'asc')->get();
    }
}
