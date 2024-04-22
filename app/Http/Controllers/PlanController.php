<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::get();

        return view("plans", compact("plans"));
    }

    public function show(Plan $plan, Request $request)
    {
        $intent = auth()->user()->createSetupIntent();

        return view("subscription", compact("plan", "intent"));
    }

    public function subscription(Request $request)
    {
        try {
            $plan = Plan::find($request->plan);

            $subscription = $request->user()
                ->newSubscription($request->plan, $plan->stripe_plan)
                ->create($request->token);

            // Subscription successfully created
            return redirect()->back()->with("success", "Payment success and subscription created!");
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error($e->getMessage());

            // Redirect back with an error message
            return redirect()->back()->with("error", "Failed to create subscription. Please try again later.");
        }
    }

}
