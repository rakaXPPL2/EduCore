<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ApiChatRequest;
use App\Models\Assignment;
use App\Models\Grade;
use App\Models\LearningMaterial;
use App\Services\GroqService;
use Illuminate\Http\JsonResponse;

class ApiChatController extends Controller
{
    public function __invoke(ApiChatRequest $request, GroqService $groq): JsonResponse
    {
        $assignments = Assignment::query()->get(['title', 'subject', 'status', 'due_at']);
        $grades = Grade::query()->get(['subject', 'score']);
        $context = [
            'student' => $request->user()->only(['name', 'email', 'role', 'student_class']),
            'progress' => [
                'average_score' => round((float) $grades->avg('score'), 1),
                'assignments_pending' => $assignments->where('status', '!=', 'submitted')->count(),
                'assignments_completed' => $assignments->where('status', 'submitted')->count(),
                'materials_available' => LearningMaterial::query()->count(),
            ],
            'assignments' => $assignments->map(fn (Assignment $assignment): array => [
                'title' => $assignment->title,
                'subject' => $assignment->subject,
                'status' => $assignment->status,
                'due_at' => $assignment->due_at?->toIso8601String(),
            ])->values()->all(),
            'grades' => $grades->map(fn (Grade $grade): array => [
                'subject' => $grade->subject,
                'score' => (float) $grade->score,
            ])->values()->all(),
        ];

        $result = $groq->askTutor($request->validated('message'), $context);

        if (! $result['success']) {
            return response()->json($result, 502);
        }

        return response()->json(['reply' => $result['reply'], 'provider' => 'groq']);
    }
}
