<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            return to_route($this->dashboardRouteFor(Auth::user()->role));
        }

        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->safe()->only(['email', 'password']);
        $credentials['role'] = $request->validated('role');

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Email, password, atau jenis akun tidak sesuai.'])->withInput($request->only('email', 'role'));
        }

        $request->session()->regenerate();

        return to_route($this->dashboardRouteFor(Auth::user()->role));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('login');
    }

    private function dashboardRouteFor(string $role): string
    {
        return match ($role) {
            'admin' => 'admin.dashboard',
            'teacher' => 'teacher.dashboard',
            default => 'student.dashboard',
        };
    }
}
