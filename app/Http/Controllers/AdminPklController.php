<?php

namespace App\Http\Controllers;

use App\Models\LokerPkl;
use App\Models\PklApplication;
use App\Models\PklDefense;
use App\Models\PklReport;
use App\Models\PklSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPklController extends Controller
{
    public function index(Request $request): View
    {
        $setting = PklSetting::query()->firstOrCreate([], ['school_level' => 'smk', 'pkl_enabled' => true]);

        // Get direct/admin PKL + approved suggestions
        $lokerPkls = LokerPkl::query()
            ->withCount('applications')
            ->with('suggestedBy')
            ->where(function ($query) {
                $query->where('suggestion_status', 'direct')
                    ->orWhere('suggestion_status', 'approved');
            })
            ->latest()
            ->get();

        // Get pending suggestions from teachers
        $pendingSuggestions = LokerPkl::query()
            ->with('suggestedBy')
            ->where('suggestion_status', 'suggested')
            ->latest()
            ->get();

        $studentSearch = trim((string) $request->query('student', ''));
        $teacherSearch = trim((string) $request->query('teacher', ''));

        $applications = PklApplication::query()
            ->with(['student', 'lokerPkl'])
            ->when($studentSearch !== '', fn ($query) => $query->whereHas('student', fn ($student) => $student->where('name', 'like', "%{$studentSearch}%")))
            ->latest()
            ->get();

        if ($teacherSearch !== '') {
            $pendingSuggestions = $pendingSuggestions->filter(fn (LokerPkl $loker): bool => str_contains(strtolower((string) $loker->suggestedBy?->name), strtolower($teacherSearch)))->values();
        }

        $reports = PklReport::query()
            ->with(['application.student', 'application.lokerPkl', 'defense'])
            ->latest()
            ->get();

        return view('admin-pkl', [
            'setting' => $setting,
            'lokerPkls' => $lokerPkls,
            'pendingSuggestions' => $pendingSuggestions,
            'applications' => $applications,
            'reports' => $reports,
            'filters' => compact('studentSearch', 'teacherSearch'),
        ]);
    }

    public function updateSetting(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'school_level' => ['required', 'in:smk,sma'],
            'period' => ['nullable', 'string', 'max:100'],
            'defense_start_date' => ['nullable', 'date'],
        ]);

        $enabled = $data['school_level'] === 'smk' && $request->boolean('pkl_enabled');
        PklSetting::query()->updateOrCreate(['id' => 1], [...$data, 'pkl_enabled' => $enabled]);

        return to_route('admin.pkl')->with('success', $enabled ? 'Fitur PKL diaktifkan untuk SMK.' : 'Fitur PKL dinonaktifkan.');
    }

    public function storeLoker(Request $request): RedirectResponse
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
            'quota' => ['required', 'integer', 'min:1', 'max:100'],
            'application_deadline' => ['nullable', 'date', 'after_or_equal:today'],
            'is_featured' => ['nullable', 'boolean'],
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
            'status' => 'published',
            'caption' => $data['description'],
            'suggestion_status' => 'direct',
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return to_route('admin.pkl')->with('success', 'Tempat PKL berhasil ditambahkan.');
    }

    public function approveSuggestion(LokerPkl $loker): RedirectResponse
    {
        abort_unless($loker->suggestion_status === 'suggested', 403);
        $loker->update(['suggestion_status' => 'approved', 'status' => 'published']);

        return to_route('admin.pkl')->with('success', 'Saran PKL dari guru berhasil disetujui.');
    }

    public function rejectSuggestion(LokerPkl $loker): RedirectResponse
    {
        abort_unless($loker->suggestion_status === 'suggested', 403);
        $loker->update(['suggestion_status' => 'rejected']);

        return to_route('admin.pkl')->with('success', 'Saran PKL dari guru ditolak.');
    }

    public function destroy(LokerPkl $loker): RedirectResponse
    {
        $loker->delete();

        return to_route('admin.pkl')->with('success', 'Tempat PKL berhasil dihapus.');
    }

    public function decideApplication(Request $request, PklApplication $application): RedirectResponse
    {
        $data = $request->validate(['status' => ['required', 'in:approved,rejected'], 'admin_note' => ['nullable', 'string', 'max:1000']]);

        if ($data['status'] === 'approved' && $application->lokerPkl->applications()->where('status', 'approved')->whereKeyNot($application->id)->count() >= $application->lokerPkl->quota) {
            abort(422, 'Kuota tempat PKL ini sudah penuh.');
        }

        $application->update($data);

        return to_route('admin.pkl')->with('success', 'Status pilihan murid berhasil diperbarui.');
    }

    public function reviewReport(Request $request, PklReport $report): RedirectResponse
    {
        $data = $request->validate(['status' => ['required', 'in:approved,revision,rejected'], 'feedback' => ['nullable', 'string', 'max:2000']]);
        $report->update([...$data, 'reviewed_by' => auth()->id(), 'reviewed_at' => now()]);

        return to_route('admin.pkl')->with('success', 'Hasil pemeriksaan laporan berhasil disimpan.');
    }

    public function scheduleDefense(Request $request, PklReport $report): RedirectResponse
    {
        abort_unless($report->status === 'approved', 422, 'Laporan harus disetujui sebelum sidang dijadwalkan.');
        $data = $request->validate(['scheduled_at' => ['required', 'date'], 'room' => ['required', 'string', 'max:100'], 'examiner' => ['required', 'string', 'max:150']]);
        PklDefense::updateOrCreate(['pkl_report_id' => $report->id], [...$data, 'user_id' => $report->user_id, 'status' => 'scheduled']);

        return to_route('admin.pkl')->with('success', 'Jadwal sidang berhasil disimpan.');
    }
}
