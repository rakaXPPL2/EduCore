<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StudentCoachRequest;
use App\Models\Assignment;
use App\Models\Grade;
use App\Models\LearningMaterial;
use App\Services\GeminiService;
use Illuminate\Http\JsonResponse;

class StudentCoachController extends Controller
{
    public function __invoke(StudentCoachRequest $request, GeminiService $gemini): JsonResponse
    {
        abort_unless($request->user()?->isStudent(), 403);

        $assignments = Assignment::query()->where('school_class_id', $request->user()->school_class_id)->get(['title', 'subject', 'status', 'due_at']);
        $grades = Grade::query()->get(['subject', 'score']);
        $materialsCount = LearningMaterial::query()->count();
        $averageScore = round((float) $grades->avg('score'), 1);
        $pendingAssignments = $assignments->where('status', '!=', 'submitted')->count();
        $completedAssignments = $assignments->where('status', 'submitted')->count();
        $focusSubject = $grades->sortBy('score')->first()?->subject ?? 'konsistensi belajar';

        $context = [
            'student' => $request->user()->name.', siswa '.($request->user()->student_class ?: 'SMK'),
            'progress' => [
                'average_score' => $averageScore,
                'assignments_pending' => $pendingAssignments,
                'assignments_completed' => $completedAssignments,
                'materials_available' => $materialsCount,
                'focus_subject' => $focusSubject,
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

        $result = $gemini->studentCoach($request->validated('message'), $context);

        if ($result['success']) {
            return response()->json(['success' => true, 'reply' => $result['data']['reply'] ?? 'Aku sudah membaca progresmu.', 'insights' => $result['data']['insights'] ?? []]);
        }

        return response()->json([
            'success' => true,
            'reply' => sprintf('Saat ini kamu punya %d tugas yang perlu diselesaikan dan %d tugas yang sudah dikumpulkan. Nilai rata-ratamu %s. Fokus perbaikan terdekat: %s.', $pendingAssignments, $completedAssignments, $averageScore, $focusSubject),
            'insights' => [
                'progress' => $averageScore >= 85 ? 'Fondasi akademikmu sudah kuat.' : 'Bangun rutinitas belajar singkat setiap hari.',
                'next_step' => 'Selesaikan tugas dengan tenggat paling dekat terlebih dahulu.',
                'future' => 'Skill web development dan basis data bisa menjadi modal untuk RPL, sistem informasi, atau informatika.',
            ],
            'fallback' => true,
        ]);
    }
}
