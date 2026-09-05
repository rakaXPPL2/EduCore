<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StudentCoachRequest;
use App\Models\Assignment;
use App\Models\Grade;
use App\Models\LearningMaterial;
use App\Services\GroqService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class StudentCoachController extends Controller
{
    public function __invoke(StudentCoachRequest $request, GroqService $groq): JsonResponse
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

        $result = $groq->askTutor($request->validated('message'), $context);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'reply' => $result['reply'],
                'insights' => [],
                'provider' => 'groq',
            ]);
        }

        $message = Str::lower($request->validated('message'));
        $reply = sprintf('Saat ini kamu punya %d tugas yang perlu diselesaikan dan %d tugas yang sudah dikumpulkan. Nilai rata-ratamu %s.', $pendingAssignments, $completedAssignments, $averageScore);
        $insights = [
            'progress' => $averageScore >= 85 ? 'Fondasi akademikmu sudah kuat.' : 'Bangun rutinitas belajar singkat setiap hari.',
            'next_step' => 'Selesaikan tugas dengan tenggat paling dekat terlebih dahulu.',
        ];

        if (Str::contains($message, ['siapa kamu', 'dirimu', 'tentang kamu', 'apa itu educoach'])) {
            $reply = 'Aku EduCoach, pendamping belajar virtual di EduCore. Aku membantu membaca progresmu, menjelaskan materi, menyusun prioritas tugas, dan memberi saran belajar berdasarkan data yang tersedia. Aku bukan pengganti guru atau konselor, jadi keputusan penting tetap perlu dibicarakan dengan wali kelas atau guru.';
            $insights['next_step'] = 'Tanyakan materi, tugas, nilai, atau rencana belajar yang ingin kamu bahas.';
        } elseif (Str::contains($message, ['kuliah', 'jurusan', 'bidang'])) {
            $reply = sprintf('Dari nilai yang tersedia, kekuatanmu paling terlihat di %s dengan rata-rata %s. Arah yang layak kamu eksplorasi adalah Rekayasa Perangkat Lunak, Informatika, atau Sistem Informasi. Coba bandingkan kurikulum dan minatmu sebelum memilih.', $focusSubject, $averageScore);
            $insights['next_step'] = 'Coba satu proyek web kecil untuk menguji minat dan kemampuanmu.';
        } elseif (Str::contains($message, ['skill', 'kemampuan', 'tingkatkan'])) {
            $reply = 'Untuk berkembang di XI RPL, prioritaskan praktik basis data, API, debugging, dan komunikasi teknis. Mulai dari satu proyek kecil lalu dokumentasikan hasilnya.';
            $insights['next_step'] = 'Pilih satu skill dan latihan 30 menit setiap hari selama seminggu.';
        } elseif (Str::contains($message, ['tugas', 'prioritas', 'dikerjakan'])) {
            $reply .= ' Fokus perbaikan terdekat: '.$focusSubject.'.';
        }

        return response()->json([
            'success' => true,
            'reply' => $reply,
            'insights' => $insights,
            'fallback' => true,
            'ai_error' => $result['error'] ?? 'AI sedang tidak tersedia.',
        ]);
    }
}
