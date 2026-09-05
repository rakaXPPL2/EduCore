<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function students(): View
    {
        $students = User::query()
            ->where('role', 'student')
            ->with('schoolClass')
            ->orderBy('name')
            ->get();

        $classes = SchoolClass::query()->orderBy('level')->orderBy('name')->get();

        return view('admin-students', [
            'students' => $students,
            'classes' => $classes,
        ]);
    }

    public function teachers(): View
    {
        $teachers = User::query()
            ->where('role', 'teacher')
            ->orderBy('name')
            ->get();

        return view('admin-teachers', [
            'teachers' => $teachers,
        ]);
    }

    public function storeStudent(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6'],
            'nis' => ['nullable', 'string', 'max:50'],
            'class_id' => ['nullable', 'exists:school_classes,id'],
        ]);

        User::create([
            ...$data,
            'role' => 'student',
            'password' => bcrypt($data['password']),
        ]);

        return to_route('admin.students')->with('success', 'Akun murid berhasil dibuat.');
    }

    public function storeTeacher(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6'],
            'teacher_subject' => ['nullable', 'string', 'max:100'],
            'nip' => ['nullable', 'string', 'max:50'],
        ]);

        User::create([
            ...$data,
            'role' => 'teacher',
            'password' => bcrypt($data['password']),
        ]);

        return to_route('admin.teachers')->with('success', 'Akun guru berhasil dibuat.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return back()->with('success', 'Pengguna berhasil dihapus.');
    }
}
