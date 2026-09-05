<?php

namespace App\Http\Controllers;

use App\Models\LokerPkl;
use App\Models\PklSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherPklController extends Controller
{
    public function suggest(): View
    {
        $setting = PklSetting::query()->first();

        $mySuggestions = LokerPkl::query()
            ->where('suggested_by', auth()->id())
            ->where('suggestion_status', 'suggested')
            ->latest()
            ->get();

        return view('teacher-suggest-pkl', [
            'setting' => $setting,
            'mySuggestions' => $mySuggestions,
        ]);
    }

    public function storeSuggestion(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'company_name' => ['required', 'string', 'max:150'],
            'location' => ['required', 'string', 'max:150'],
            'address' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:3000'],
            'major' => ['nullable', 'string', 'max:100'],
            'class_level' => ['nullable', 'in:10,11,12'],
            'class_number' => ['nullable', 'string', 'max:20'],
            'poster' => ['nullable', 'image', 'max:2048'],
            'quota' => ['required', 'integer', 'min:1', 'max:10'],
            'application_deadline' => ['nullable', 'date', 'after_or_equal:today'],
        ]);

        $setting = PklSetting::query()->first();
        abort_unless($setting?->pkl_enabled, 403);

        $posterPath = null;
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('pkl-posters', 'public');
        }

        LokerPkl::create([
            'company_name' => $data['company_name'],
            'location' => $data['location'],
            'address' => $data['address'] ?? null,
            'description' => $data['description'],
            'major' => $data['major'] ?? null,
            'class_level' => $data['class_level'] ?? null,
            'class_number' => $data['class_number'] ?? null,
            'poster_path' => $posterPath,
            'quota' => $data['quota'],
            'application_deadline' => $data['application_deadline'] ?? null,
            'school_level' => $setting->school_level,
            'status' => 'draft',
            'caption' => $data['description'],
            'suggested_by' => auth()->id(),
            'suggestion_status' => 'suggested',
            'is_featured' => false,
        ]);

        return to_route('teacher.pkl.suggest')->with('success', 'Saran tempat PKL berhasil dikirim untuk persetujuan admin.');
    }
}
