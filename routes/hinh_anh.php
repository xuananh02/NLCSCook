<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HinhAnhController;

Route::middleware('guest')->group(function () {
    Route::post('/uploadImage', [HinhAnhController::class, 'storeMul']);
});