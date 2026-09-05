<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_pages_are_available(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'student']));

        foreach (['/', '/murid/jadwal', '/murid/nilai', '/murid/materi', '/murid/surat-izin'] as $path) {
            $this->get($path)->assertOk();
        }
    }

    public function test_guest_cannot_open_student_pages(): void
    {
        $this->get('/murid/nilai')->assertRedirect('/login');
    }

    public function test_student_can_submit_a_permit_request(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'student']));

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
        $this->actingAs(User::factory()->create(['role' => 'student']));

        $this->post('/murid/surat-izin', [])->assertSessionHasErrors([
            'student_name', 'type', 'permit_date', 'description',
        ]);
    }

    public function test_student_coach_returns_a_progress_fallback_without_ai_credentials(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'student']));

        $this->postJson('/api/student-coach/chat', [
            'message' => 'Tugas mana yang harus aku kerjakan dulu?',
        ])->assertOk()->assertJsonPath('success', true)->assertJsonStructure([
            'reply',
            'insights',
        ]);
    }
}
