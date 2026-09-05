<?php

namespace App\Http\Controllers;

use App\Models\PermitRequest;
use App\Models\PklApplication;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'students' => User::query()->where('role', 'student')->count(),
            'teachers' => User::query()->where('role', 'teacher')->count(),
            'classes' => SchoolClass::query()->count(),
            'pendingPermits' => PermitRequest::query()->where('status', 'pending')->count(),
            'pendingPkl' => PklApplication::query()->where('status', 'pending')->count(),
        ];

        $recentPermits = PermitRequest::query()
            ->with('student')
            ->latest()
            ->take(5)
            ->get();

        $recentStudents = User::query()
            ->where('role', 'student')
            ->latest()
            ->take(6)
            ->get();

        $recentTeachers = User::query()
            ->where('role', 'teacher')
            ->latest()
            ->take(4)
            ->get();

        $classes = SchoolClass::query()
            ->withCount('students')
            ->orderBy('level')
            ->orderBy('name')
            ->get();

        // Group classes by level
        $classesByLevel = $classes->groupBy('level')->sortKeys();

        return view('admin-dashboard', [
            'stats' => $stats,
            'recentPermits' => $recentPermits,
            'recentStudents' => $recentStudents,
            'recentTeachers' => $recentTeachers,
            'classesByLevel' => $classesByLevel,
            'classes' => $classes,
        ]);
    }
}
