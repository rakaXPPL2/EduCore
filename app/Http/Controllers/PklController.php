<?php

namespace App\Http\Controllers;

use App\Models\LokerPkl;
use App\Models\PklApplication;
use App\Models\PklSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PklController extends Controller
{
    public function index(Request $request): View
    {
        $setting = PklSetting::query()->firstOrCreate([], ['school_level' => 'smk', 'pkl_enabled' => true]);
        $applications = PklApplication::query()->with(['lokerPkl', 'report.defense'])->where('user_id', auth()->id())->latest()->get();
        $search = trim((string) $request->query('q', ''));
        $major = trim((string) $request->query('major', ''));
        $classLevel = trim((string) $request->query('class_level', ''));
        $classNumber = trim((string) $request->query('class_number', ''));

        $lokerQuery = LokerPkl::query()
            ->withCount(['applications as approved_applications' => fn ($query) => $query->where('status', 'approved')])
            ->where('school_level', $setting->school_level)
            ->where('status', 'published')
            ->where(function ($query) {
                $query->where('suggestion_status', 'direct')
                    ->orWhere('suggestion_status', 'approved');
            });

        if ($search !== '') {
            $lokerQuery->where(function ($query) use ($search): void {
                $query->where('company_name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $lokerPkls = $setting->pkl_enabled ? $lokerQuery
            ->when($major !== '', fn ($query) => $query->where('major', $major))
            ->when($classLevel !== '', fn ($query) => $query->where('class_level', $classLevel))
            ->when($classNumber !== '', fn ($query) => $query->where('class_number', $classNumber))
            ->orderByRaw('case when class_level is null then 99 else cast(class_level as integer) end')
            ->orderBy('class_number')
            ->latest()
            ->get() : collect();

        return view('student-pkl', [
            'setting' => $setting,
            'lokerPkls' => $lokerPkls,
            'groupedLokerPkls' => $lokerPkls->groupBy(fn (LokerPkl $loker): string => $loker->class_level ?: 'Semua tingkat'),
            'majors' => LokerPkl::query()->where('school_level', $setting->school_level)->whereNotNull('major')->distinct()->orderBy('major')->pluck('major'),
            'filters' => compact('search', 'major', 'classLevel', 'classNumber'),
            'applications' => $applications,
        ]);
    }

    public function apply(Request $request, LokerPkl $lokerPkl): RedirectResponse
    {
        $setting = PklSetting::query()->first();
        abort_unless($setting?->pkl_enabled && $lokerPkl->status === 'published' && $lokerPkl->school_level === $setting->school_level, 403);
        abort_if($lokerPkl->application_deadline?->isBefore(today()), 422, 'Batas pendaftaran tempat PKL ini sudah berakhir.');

        $data = $request->validate(['motivation' => ['nullable', 'string', 'max:2000']]);
        abort_if($lokerPkl->applications()->where('status', 'approved')->count() >= $lokerPkl->quota, 422, 'Kuota tempat PKL ini sudah penuh.');

        PklApplication::updateOrCreate(
            ['user_id' => auth()->id(), 'loker_pkl_id' => $lokerPkl->id],
            ['motivation' => $data['motivation'] ?? null, 'status' => 'pending', 'admin_note' => null],
        );

        return to_route('student.pkl')->with('success', 'Pilihan tempat PKL berhasil dikirim untuk diproses admin.');
    }

    public function storeReport(Request $request, PklApplication $application): RedirectResponse
    {
        abort_unless($application->user_id === auth()->id() && $application->status === 'approved', 403);
        $data = $request->validate(['report' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240']]);
        $path = $data['report']->store('pkl-reports', 'public');

        $application->report()->updateOrCreate(
            ['pkl_application_id' => $application->id],
            ['user_id' => auth()->id(), 'report_path' => $path, 'status' => 'pending', 'feedback' => null, 'reviewed_by' => null, 'reviewed_at' => null],
        );

        return to_route('student.pkl')->with('success', 'Laporan PKL berhasil dikirim untuk diperiksa admin.');
    }
}
