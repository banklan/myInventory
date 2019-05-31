<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\DailyBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function getBatchStatus()
    {
        $user = Auth::id();
        $today = Carbon::now()->toDateString();
        $status = DailyBatch::where('user_id', $user)->where('batch', $today)->first();
        if(!$status){
            return response()->json(0, 200);
        }else{
            return response()->json(1, 200);
        }
    }

    public function openBatch()
    {
        $user = Auth::id();
        $today = Carbon::now()->toDateString();
        
        $batch = new DailyBatch();
        $batch->user_id = $user;
        $batch->role_id = 1;
        $batch->batch = $today;
        $batch->open = 1;
        $batch->save();

        return response()->json($batch, 200);
    }
}
