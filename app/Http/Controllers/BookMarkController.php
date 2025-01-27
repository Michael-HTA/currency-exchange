<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookmarkRequest;
use App\Http\Requests\BookmarkStoreRequest;
use App\Http\Resources\BookmarkCollection;
use App\Http\Resources\BookmarkResource;
use App\Models\Bookmark;
use App\Models\Currency;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BookmarkController extends Controller
{
    public function index(BookmarkRequest $request)
    {
        $userId = Auth::id();
        $currencies = Currency::all();
        $validated = $request->validated();

        if (isset($validated['baseCurrency']) && isset($validated['targetedCurrency'])) {

            $baseCurrency = Currency::where('code', $validated['baseCurrency'])->first();
            $targetedCurrency = Currency::where('code', $validated['targetedCurrency'])->first();
            $userBookmarks = Bookmark::where('base_id', $baseCurrency->id)->where('targeted_id', $targetedCurrency->id)->paginate(8);

            return view('bookmark', [
                'currencies' => $currencies,
                'userBookmarks' => $userBookmarks,
                'baseCurrency' => $validated['baseCurrency'],
                'targetedCurrency' => $validated['targetedCurrency'],
            ]);

        } else {
            $userBookmarks = Bookmark::with(['baseCurrency', 'targetedCurrency'])->where('user_id', $userId)->paginate(8);

            return view('bookmark', [
                'currencies' => $currencies,
                'userBookmarks' => $userBookmarks,
                'baseCurrency' => $validated['baseCurrency'] ?? 'USD',
                'targetedCurrency' => $validated['targetedCurrency'] ?? 'THB',
            ]);
        }
    }

    public function store(BookmarkStoreRequest $request)
    {
        try {
            $bookmark = new Bookmark();
            $validated = $request->validated();
            $baseCurrency = Currency::where('code', $validated['baseCurrency'])->first();
            $targetedCurrency = Currency::where('code', $validated['targetedCurrency'])->first();

            $bookmark->user_id = Auth::id();
            $bookmark->amount = $validated['amount'];
            $bookmark->base_id = $baseCurrency->id;
            $bookmark->targeted_id = $targetedCurrency->id;
            $bookmark->exchange_rate = $validated['exchangeRate'];
            $bookmark->reverse_exchange_rate = $validated['reverseExchangeRate'];

            $bookmark->save();

            return response()->json([
                'statusCode' => 200,
                'message' => 'success',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'error' => 'Something wrong'
            ], 500);
        }
    }

    public function destroy(Request $request)
    {

        try {
            $validated = $request->validate([
                'id' => 'required|integer',
            ]);

            $bookmark = Bookmark::find($validated['id']);

            $bookmark->delete();

            return response()->json([
                'statusCode' => 200,
                'message' => 'success',
            ]);
        } catch (Exception $e) {

            Log::error($e->getMessage());

            return response()->json([
                'error' => 'Something wrong'
            ], 500);
        }
    }
}
