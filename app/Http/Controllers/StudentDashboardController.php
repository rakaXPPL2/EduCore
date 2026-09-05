<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermitRequest;
use App\Models\Assignment;
use App\Models\Grade;
use App\Models\LearningMaterial;
use App\Models\PermitRequest;
use App\Models\Schedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StudentDashboardController extends Controller
{
    public function index(): View
    {
        $student = auth()->user();

        return view('student-dashboard', [
            'assignments' => Assignment::query()->where('school_class_id', $student->school_class_id)->orderBy('due_at')->get(),
            'upcomingSchedules' => Schedule::query()
                ->where('school_class_id', $student->school_class_id)
                ->whereDate('schedule_date', '>=', now()->toDateString())
                ->orderBy('schedule_date')
                ->orderBy('starts_at')
                ->limit(3)
                ->get(),
        ]);
    }

    public function schedule(): View
    {
        return $this->page('Jadwal pelajaran', 'Atur ritme belajar dengan jadwal yang selalu terbarui.', [
            'schedules' => Schedule::query()->where('school_class_id', auth()->user()->school_class_id)->orderBy('schedule_date')->orderBy('starts_at')->get(),
        ]);
    }

    public function grades(): View
    {
        return $this->page('Nilai saya', 'Pantau perkembangan hasil belajar di setiap mata pelajaran.', [
            'grades' => Grade::query()->orderBy('subject')->get(),
        ]);
    }

    public function materials(): View
    {
        return $this->page('Materi belajar', 'Temukan materi yang dibagikan guru untuk mendukung belajarmu.', [
            'materials' => LearningMaterial::query()->where('school_class_id', auth()->user()->school_class_id)->latest('published_at')->get(),
        ]);
    }

    public function permits(): View
    {
        return $this->page('Surat dan izin', 'Kirim pengajuan izin dan pantau status persetujuannya.', [
            'permitRequests' => PermitRequest::query()->where('student_name', auth()->user()->name)->latest()->get(),
        ]);
    }

    public function storePermit(StorePermitRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $attachmentPath = $request->file('attachment')?->store('permit-attachments', 'public');

        PermitRequest::create([
            'student_name' => $data['student_name'],
            'type' => $data['type'],
            'permit_date' => $data['permit_date'],
            'description' => $data['description'],
            'attachment_path' => $attachmentPath,
            'status' => 'pending',
        ]);

        return to_route('student.permits')->with('success', 'Pengajuan izin berhasil dikirim.');
    }

    private function page(string $title, string $description, array $data): View
    {
        return view('student-page', array_merge($data, compact('title', 'description')));
    }
}
