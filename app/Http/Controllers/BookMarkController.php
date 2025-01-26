<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookmarkRequest;
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
    public function index()
    {
        $userId = Auth::id();

        $userBookmark = Bookmark::with(['baseCurrency', 'targetedCurrency'])->where('user_id', $userId)->paginate(9);

        return view('bookmark', [
            'userBookmarks' => $userBookmark,
        ]);
    }

    public function store(BookmarkRequest $request)
    {
        try {
            $bookmark = new Bookmark();
            $validated = $request->validated();
            $baseCurrency = Currency::where('code', $validated['base_currency'])->first();
            $targetedCurrency = Currency::where('code', $validated['targeted_currency'])->first();

            $bookmark->user_id = Auth::id();
            $bookmark->amount = $validated['amount'];
            $bookmark->base_id = $baseCurrency->id;
            $bookmark->targeted_id = $targetedCurrency->id;
            $bookmark->exchange_rate = $validated['exchange_rate'];
            $bookmark->reverse_exchange_rate = $validated['reverse_exchange_rate'];

            $bookmark->save();

            return response()->json([
                'statusCode' => 200,
                'message' => 'success',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'error' => 'Something wrong'
            ],500);
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

            return response()->json('success');
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }
}
