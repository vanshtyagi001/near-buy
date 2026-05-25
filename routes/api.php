<?php

use App\Http\Controllers\Api\DealApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/deals', [DealApiController::class, 'index']);
Route::get('/deals/{id}', [DealApiController::class, 'show']);