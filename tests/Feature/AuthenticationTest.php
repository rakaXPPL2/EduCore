<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_open_the_public_landing_page(): void
    {
        $this->get('/')->assertOk()->assertSee('SMKN 1 Garut');
    }

    public function test_student_login_reaches_student_dashboard(): void
    {
        User::factory()->create(['email' => 'murid@test.test', 'password' => 'password', 'role' => 'student']);

        $this->post('/login', ['email' => 'murid@test.test', 'password' => 'password', 'role' => 'student'])
            ->assertRedirect('/dashboard-murid');
        $this->assertAuthenticated();
    }

    public function test_teacher_login_reaches_teacher_dashboard(): void
    {
        User::factory()->create(['email' => 'guru@test.test', 'password' => 'password', 'role' => 'teacher']);

        $this->post('/login', ['email' => 'guru@test.test', 'password' => 'password', 'role' => 'teacher'])
            ->assertRedirect('/guru/dashboard');
    }

    public function test_role_cannot_access_the_other_dashboard(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $this->actingAs($student)->get('/guru/dashboard')->assertForbidden();
        $this->post('/logout')->assertRedirect('/login');
    }

    public function test_invalid_credentials_are_rejected(): void
    {
        $this->post('/login', [
            'email' => 'unknown@test.test',
            'password' => 'wrong-password',
            'role' => 'student',
        ])->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_admin_can_open_class_management(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->get('/admin/kelas')->assertOk();
    }
}
