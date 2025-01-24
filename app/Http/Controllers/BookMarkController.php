<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookmarkRequest;
use App\Http\Resources\BookmarkCollection;
use App\Http\Resources\BookmarkResource;
use App\Models\Bookmark;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BookmarkController extends Controller
{

    private $currencies = [
        'USD' => 1,
        'THB' => 6,
        'PHP' => 7,
        'SGD' => 8,
        'MYR' => 9,
    ];

    public function index() {

        $userId = Auth::id();

        $userBookmark = Bookmark::with(['baseCurrency','targetedCurrency'])->where('user_id',$userId)->paginate(9);

        return view('bookmark',[
            'userBookmarks' => $userBookmark,
        ]);
    }

    public function store(BookmarkRequest $request)
    {
        try {
            $bookmark = new Bookmark();
            $validated = $request->validated();

            $bookmark->user_id = Auth::id();
            $bookmark->amount = $validated['amount'];
            $bookmark->base_id = $this->currencies[$validated['base_currency']];
            $bookmark->targeted_id = $this->currencies[$validated['targeted_currency']];
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
            ]);
        }
    }

    public function destroy(Request $request){

        try{
            $validated = $request->validate([
                'id' => 'required|integer',
            ]);

            $bookmark = Bookmark::find($validated['id']);

            $bookmark->delete();

            return response()->json('success');

        } catch(Exception $e){

            return $e->getMessage();
        }

    }
}
