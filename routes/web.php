<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/testing', function () {
//     $response = Http::asForm()->withHeaders([
//         'key' => config('services.rajaongkir.api_key'),
//         'Accept' => 'application/json',
//     ])->post(config('services.rajaongkir.base_url') . '/calculate/domestic-cost', [
//         'origin' => 128,
//         'destination' => 17,
//         'weight' => 500,
//         'courier' => 'jne',
//     ]);

//     $result = collect($response->object());

//     dd($result);
// });

Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransController::class, 'callback']);