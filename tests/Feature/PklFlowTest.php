<?php

namespace Tests\Feature;

use App\Models\LokerPkl;
use App\Models\PklSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PklFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_close_pkl_for_sma(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->post(route('admin.pkl.settings.update'), [
            'school_level' => 'sma',
            'period' => '2026/2027',
        ])->assertRedirect(route('admin.pkl'));

        $this->assertDatabaseHas('pkl_settings', ['school_level' => 'sma', 'pkl_enabled' => false]);
        $this->actingAs($admin)->get(route('admin.pkl'))->assertOk();
    }

    public function test_student_can_choose_a_published_pkl_place(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        PklSetting::create(['school_level' => 'smk', 'pkl_enabled' => true]);
        $loker = LokerPkl::create([
            'company_name' => 'Mitra Digital',
            'location' => 'Garut',
            'school_level' => 'smk',
            'caption' => 'Praktik pengembangan web',
            'description' => 'Belajar pengembangan web.',
            'quota' => 2,
            'status' => 'published',
        ]);

        $this->actingAs($student)->post(route('student.pkl.apply', $loker), [
            'motivation' => 'Sesuai dengan minat saya.',
        ])->assertRedirect(route('student.pkl'));

        $this->actingAs($student)->get(route('student.pkl'))->assertOk();

        $this->assertDatabaseHas('pkl_applications', [
            'user_id' => $student->id,
            'loker_pkl_id' => $loker->id,
            'status' => 'pending',
        ]);
    }
}
