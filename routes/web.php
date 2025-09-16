<?php

use App\Models\Country;
use App\Models\Denomination;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // This route now correctly points to your DashboardController
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
});

//registration
Route::get('/register', function () {
    $denominations = Denomination::orderBy('name')->get();
    $countries = Country::orderBy('name')->get();

    return view('auth.register', [
        'denominations' => $denominations,
        'countries' => $countries,
    ]);
})->name('register');

