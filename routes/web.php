<?php

use App\Http\Controllers\PlanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::middleware("auth")->group(function () {
    // Route::get('plans', [PlanController::class, 'index']);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('plans/{plan}', [PlanController::class, 'show'])->name("plans.show");
    Route::post('subscription', [PlanController::class, 'subscription'])->name("subscription.create");
    Route::get('cancel-subscription/{stripe_plan}', [PlanController::class, 'cancelSubscription'])->name("subscription.cancel");
    Route::get('resume-subscription/{user_id}/{stripe_plan}', [PlanController::class, 'resumeSubscription'])->name("subscription.resume");
});
