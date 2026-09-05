<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ApiVerifyDocumentRequest;
use App\Services\GeminiService;
use Illuminate\Http\JsonResponse;

class ApiDocumentController extends Controller
{
    public function verify(ApiVerifyDocumentRequest $request, GeminiService $gemini): JsonResponse
    {
        $result = $gemini->verifyPermitLetter(
            $request->file('image')->getRealPath(),
            $request->user()->name,
            now()->toDateString(),
        );

        return response()->json($result, $result['success'] ? 200 : 502);
    }
}
