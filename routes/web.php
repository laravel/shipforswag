<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OgImageController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/og-image.png', OgImageController::class)->name('og-image');
