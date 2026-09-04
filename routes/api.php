<?php

declare(strict_types=1);

use App\Http\Controllers\GeminiController;
use Illuminate\Support\Facades\Route;

Route::post('/gemini/analyze-pkl-job', [GeminiController::class, 'analyzePklJob']);
Route::post('/gemini/verify-permit-letter', [GeminiController::class, 'verifyPermitLetter']);
