<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Exceptions\IncompletePayment;

class PlanController extends Controller
{
    // public function index()
    // {
    //     $plans = Plan::get();
    //     $alreadySubscribe = Subscription::where('ends_at', NULL)->pluck('stripe_price')->toArray();

    //     return view("plans", compact("plans", "alreadySubscribe"));
    // }

    public function show(Plan $plan, Request $request)
    {
        $intent = auth()->user()->createSetupIntent();

        return view("subscription", compact("plan", "intent"));
    }

    public function subscription(Request $request)
    {
        $plan = Plan::findOrFail($request->plan);
        $user = auth()->user();

        $paymentMethod = $request->token;
        $user->createOrGetStripeCustomer(['name' => $user->name, 'address' => [
            'line1' => '123 Main Street',
            'postal_code' => 'SW1A 1AA',
            'city' => 'London',
            'state' => 'England',
            // 'line2' => 'Apt 4B',
            'country' => 'GB'
        ]]);

        $user->addPaymentMethod($paymentMethod);

        try {
            $subscription = $request->user()
                ->newSubscription($plan->name, $plan->stripe_plan)
                ->create($request->token);

            return redirect()->route('home')->with('success', 'Subscription created successfully!');
        } catch (IncompletePayment $exception) {


            return redirect()->route(
                'cashier.payment',
                [$exception->payment->id, 'redirect' => route('home')]
            );
        }
    }

    public function cancelSubscription($stripe_plan)
    {
        try {
            $user = auth()->user();
            $user->subscription($stripe_plan)->cancel();

            return redirect()->route('home')->with('success', 'Subscription Cancel successfully!');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    public function resumeSubscription($user_id, $stripe_plan)
    {
        try {
            $user = User::where('id',$user_id)->first();
            $user->subscription($stripe_plan)->resume();

            return redirect()->route('home')->with('success', 'Subscription Resume successfully!');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }
}
