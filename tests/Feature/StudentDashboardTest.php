<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\LokerPkl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StudentDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_pages_are_available(): void
    {
        foreach (['/', '/murid/jadwal', '/murid/nilai', '/murid/materi', '/murid/surat-izin'] as $path) {
            $this->get($path)->assertOk();
        }
    }

    public function test_student_can_submit_a_permit_request(): void
    {
        $response = $this->post('/murid/surat-izin', [
            'student_name' => 'Aditya Ramadhan',
            'type' => 'Izin sakit',
            'permit_date' => '2026-09-07',
            'description' => 'Demam dan perlu beristirahat di rumah.',
        ]);

        $response->assertRedirect('/murid/surat-izin');
        $this->assertDatabaseHas('permit_requests', [
            'student_name' => 'Aditya Ramadhan',
            'type' => 'Izin sakit',
            'status' => 'pending',
        ]);
    }

    public function test_permit_request_requires_its_core_fields(): void
    {
        $this->post('/murid/surat-izin', [])->assertSessionHasErrors([
            'student_name', 'type', 'permit_date', 'description',
        ]);
    }

    public function test_student_coach_returns_a_progress_fallback_without_ai_credentials(): void
    {
        $this->postJson('/api/student-coach/chat', [
            'message' => 'Tugas mana yang harus aku kerjakan dulu?',
        ])->assertOk()->assertJsonPath('success', true)->assertJsonStructure([
            'reply',
            'insights',
        ]);
    }

    public function test_student_can_submit_an_assignment_file(): void
    {
        Storage::fake('local');
        $assignment = Assignment::create([
            'title' => 'Membuat API Laravel',
            'subject' => 'Pemrograman Web',
            'due_at' => now()->addDay(),
        ]);

        $response = $this->post(route('student.assignments.submit', $assignment), [
            'submission' => UploadedFile::fake()->create('jawaban.pdf', 100, 'application/pdf'),
        ]);

        $response->assertRedirect(route('student.dashboard'));
        $assignment->refresh();
        $this->assertSame('submitted', $assignment->status);
        $this->assertNotNull($assignment->submitted_at);
        Storage::disk('local')->assertExists($assignment->submission_path);
    }

    public function test_student_coach_uses_gemini_response_when_credentials_are_configured(): void
    {
        config()->set('services.gemini.key', 'test-key');
        Http::fake([
            '*' => Http::response([
                'candidates' => [[
                    'content' => [
                        'parts' => [[
                            'text' => json_encode([
                                'reply' => 'Kerjakan tugas dengan tenggat paling dekat.',
                                'insights' => [['label' => 'Prioritas', 'value' => 'Tugas terdekat']],
                            ]),
                        ]],
                    ],
                ]],
            ]),
        ]);

        $this->postJson('/api/student-coach/chat', [
            'message' => 'Tugas mana yang harus aku kerjakan dulu?',
        ])->assertOk()->assertJsonPath('reply', 'Kerjakan tugas dengan tenggat paling dekat.');

        Http::assertSent(fn ($request): bool => $request->hasHeader('x-goog-api-key', 'test-key'));
    }

    public function test_permit_modal_posts_to_the_real_backend_endpoint(): void
    {
        $this->get('/')->assertOk()->assertSee('action="'.route('student.permits.store').'"', false);
    }

    public function test_gemini_can_analyze_and_store_a_pkl_vacancy(): void
    {
        config()->set('services.gemini.key', 'test-key');
        Http::fake([
            '*' => Http::response([
                'candidates' => [[
                    'content' => ['parts' => [['text' => json_encode([
                        'ringkasan' => 'Membangun aplikasi web.',
                        'bidang' => 'Teknologi',
                        'rekomendasi_jurusan' => ['Rekayasa Perangkat Lunak'],
                        'skills' => ['Laravel'],
                        'tingkat_kesesuaian' => 90,
                    ])]]],
                ]],
            ]),
        ]);

        $this->postJson('/api/gemini/analyze-pkl-job', [
            'caption' => 'Dibutuhkan siswa untuk membantu membangun aplikasi web menggunakan Laravel.',
        ])->assertCreated()->assertJsonPath('success', true);

        $this->assertDatabaseHas('loker_pkls', [
            'caption' => 'Dibutuhkan siswa untuk membantu membangun aplikasi web menggunakan Laravel.',
        ]);
        $this->assertSame(1, LokerPkl::count());
    }
}
