<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\PermitRequest;
use App\Models\User;
use Illuminate\View\View;

class TeacherDashboardController extends Controller
{
    public function index(): View
    {
        return view('teacher-dashboard', [
            'assignmentCount' => Assignment::query()->count(),
            'pendingPermits' => PermitRequest::query()->where('status', 'pending')->count(),
            'studentCount' => User::query()->where('role', 'student')->count(),
            'recentPermits' => PermitRequest::query()->latest()->limit(5)->get(),
        ]);
    }
}
