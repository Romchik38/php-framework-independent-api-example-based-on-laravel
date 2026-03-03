<?php

use App\Http\Controllers\CarrierCalculateFormController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CarrierCalculateFormController::class, 'index'])
    ->name('home');
