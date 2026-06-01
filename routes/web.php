<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'plans' => \App\Models\Plan::active()->orderBy('sort_order')->get(),
    ]);
})->name('home');
Route::get('/privacy-policy', function () {
    return Inertia::render('PrivacyPolicy',[
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('privacy-policy');
Route::get('/terms-conditions', function () {
    return Inertia::render('TermsConditions',[
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('terms-conditions');

Route::get('/disclaimer', function () {
    return Inertia::render('Disclaimer', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('disclaimer');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');
    Route::post('/billing/checkout/{plan}/{interval}', [BillingController::class, 'checkout'])->name('billing.checkout');
    Route::post('/billing/portal', [BillingController::class, 'portal'])->name('billing.portal');
    Route::post('/billing/cancel', [BillingController::class, 'cancel'])->name('billing.cancel');
    Route::post('/billing/resume', [BillingController::class, 'resume'])->name('billing.resume');
    Route::get('/billing/success', [BillingController::class, 'success'])->name('billing.success');
    Route::get('/billing/cancelled', [BillingController::class, 'cancelled'])->name('billing.cancelled');

    Route::get('/history', function () {
        $histories = \App\Models\CalculatorHistory::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->latest()
            ->get();

        return Inertia::render('History', ['histories' => $histories]);
    })->middleware('feature:audit_history')->name('history');

    // Calculators Front-end Routes
    Route::get('/calculator/monthly-sales-goal', function () { return Inertia::render('Calculators/MonthlySalesGoal'); })->middleware('feature:monthly_sales_goal')->name('calculator.monthly-sales-goal');
    Route::get('/calculator/break-even-and-selling-price', function () { return Inertia::render('Calculators/BreakEvenPrice'); })->middleware('feature:break_even_price')->name('calculator.break-even-and-selling-price');
    Route::get('/calculator/future-sales-forecast', function () { return Inertia::render('Calculators/FutureSalesForecast'); })->middleware('feature:future_sales_forecast')->name('calculator.future-sales-forecast');
    Route::get('/calculator/what-if-engine', function () { return Inertia::render('Calculators/WhatIfEngine'); })->middleware('feature:what_if_engine')->name('calculator.what-if-engine');
    Route::get('/calculator/ltv-cac-ratio', function () { return Inertia::render('Calculators/LTVtoCAC'); })->middleware('feature:ltv_cac_ratio')->name('calculator.ltv-cac-ratio');

    // Calculators Logic Endpoints
    Route::post('/api/calculator/monthly-sales-goal', [\App\Http\Controllers\CalculatorController::class, 'monthlySalesGoal'])->middleware('feature:monthly_sales_goal')->name('api.calculator.monthly-sales-goal');
    Route::post('/api/calculator/break-even-and-selling-price', [\App\Http\Controllers\CalculatorController::class, 'breakEvenPrice'])->middleware('feature:break_even_price')->name('api.calculator.break-even-and-selling-price');
    Route::post('/api/calculator/future-sales-forecast', [\App\Http\Controllers\CalculatorController::class, 'futureSalesForecast'])->middleware('feature:future_sales_forecast')->name('api.calculator.future-sales-forecast');
    Route::post('/api/calculator/ltv-cac-ratio', [\App\Http\Controllers\CalculatorController::class, 'ltvCacRatio'])->middleware('feature:ltv_cac_ratio')->name('api.calculator.ltv-cac-ratio');

    Route::middleware('admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::patch('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        
        Route::get('/admin/plans', [AdminController::class, 'plans'])->name('admin.plans');
        Route::post('/admin/plans', [AdminController::class, 'storePlan'])->name('admin.plans.store');
        Route::patch('/admin/plans/{plan}', [AdminController::class, 'updatePlan'])->name('admin.plans.update');
        
        Route::get('/admin/subscriptions', [AdminController::class, 'subscriptions'])->name('admin.subscriptions');
    });
});

require __DIR__.'/auth.php';
