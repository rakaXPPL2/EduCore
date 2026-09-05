<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSchoolClassRequest;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function classes(): View
    {
        return view('admin-classes', [
            'classes' => SchoolClass::query()->with('homeroomTeacher')->withCount('students')->orderBy('name')->get(),
            'teachers' => User::query()->where('role', 'teacher')->orderBy('name')->get(),
        ]);
    }

    public function storeClass(StoreSchoolClassRequest $request): RedirectResponse
    {
        SchoolClass::create($request->validated());

        return to_route('admin.classes')->with('success', 'Kelas dan wali kelas berhasil dibuat.');
    }
}
