<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookMarkRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookMarkController extends Controller
{

    public function index(){

    }

    public function store(Request $request)
    {
        // $validated = $request->validated();
        // return $request->all();
        // return response()->json(['id' =>  Auth::id()]);

    }
}
