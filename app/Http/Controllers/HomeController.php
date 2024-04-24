<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $plans = Plan::get();
        $currentDate = Carbon::now()->toDateTimeString();
        $alreadySubscribe = Subscription::where('ends_at', '>=', $currentDate )->pluck('stripe_price')->toArray();

        return view("plans", compact("plans", "alreadySubscribe"));
    }
}
