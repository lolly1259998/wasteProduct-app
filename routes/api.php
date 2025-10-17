<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AI\AIController;

Route::post('/ai/predict', [AIController::class, 'predictWasteTreatment']);
use App\Http\Controllers\Campaign\CampaignController;

Route::apiResource('campaigns', CampaignController::class);
