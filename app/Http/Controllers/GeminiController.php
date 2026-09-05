<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\AnalyzePklJobRequest;
use App\Http\Requests\VerifyPermitLetterRequest;
use App\Models\LokerPkl;
use App\Services\GeminiService;
use Illuminate\Http\JsonResponse;

class GeminiController extends Controller
{
    public function analyzePklJob(AnalyzePklJobRequest $request, GeminiService $gemini): JsonResponse
    {
        $result = $gemini->analyzePklJob($request->validated('caption'));

        if (! $result['success']) {
            return response()->json($result, 502);
        }

        $analysis = $result['data'];
        LokerPkl::create([
            'caption' => $request->validated('caption'),
            'hasil_analisis' => $analysis,
            'rekomendasi_jurusan' => $analysis['rekomendasi_jurusan'] ?? [],
        ]);

        return response()->json($result, 201);
    }

    public function verifyPermitLetter(VerifyPermitLetterRequest $request, GeminiService $gemini): JsonResponse
    {
        $result = $gemini->verifyPermitLetter(
            $request->file('image')->getRealPath(),
            $request->validated('student_name'),
            $request->validated('permit_date'),
        );

        return response()->json($result, $result['success'] ? 200 : 502);
    }
}
