<?php

declare(strict_types=1);

use App\Http\Controllers\GeminiController;
use App\Http\Controllers\LokerPklController;
use App\Http\Controllers\StudentCoachController;
use Illuminate\Support\Facades\Route;

Route::post('/gemini/analyze-pkl-job', [GeminiController::class, 'analyzePklJob']);
Route::post('/gemini/verify-permit-letter', [GeminiController::class, 'verifyPermitLetter']);
Route::apiResource('loker-pkl', LokerPklController::class)->only(['store', 'show', 'update', 'destroy']);
Route::post('/student-coach/chat', StudentCoachController::class)
    ->middleware('throttle:30,1')
    ->name('api.student-coach.chat');
