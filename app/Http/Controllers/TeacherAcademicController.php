<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssignmentRequest;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TeacherAcademicController extends Controller
{
    public function assignments(): View
    {
        return view('teacher-assignments', [
            'classes' => SchoolClass::query()->with('homeroomTeacher')->orderBy('name')->get(),
            'subjects' => Subject::query()->orderBy('name')->get(),
            'assignments' => Assignment::query()->where('teacher_id', auth()->id())->with('schoolClass', 'subjectModel')->latest()->get(),
        ]);
    }

    public function storeAssignment(StoreAssignmentRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $filePath = $request->file('file')?->store('assignments', 'public');
        $subject = Subject::query()->findOrFail($data['subject_id']);

        Assignment::create([
            'title' => $data['title'], 'description' => $data['description'],
            'school_class_id' => $data['school_class_id'], 'subject_id' => $data['subject_id'],
            'teacher_id' => auth()->id(), 'teacher' => auth()->user()->name, 'subject' => $subject->name,
            'due_at' => $data['due_at'], 'max_points' => $data['max_points'],
            'file_path' => $filePath, 'resource_link' => $data['resource_link'] ?? null,
        ]);

        return to_route('teacher.assignments')->with('success', 'Tugas berhasil diterbitkan untuk kelas yang dipilih.');
    }

    public function gradebook(Assignment $assignment): View
    {
        abort_unless($assignment->teacher_id === auth()->id(), 403);
        $students = User::query()->where('role', 'student')->where('school_class_id', $assignment->school_class_id)->with(['submissions' => fn ($query) => $query->where('assignment_id', $assignment->id)])->orderBy('name')->get();

        return view('teacher-gradebook', compact('assignment', 'students'));
    }

    public function updateGrade(AssignmentSubmission $submission): RedirectResponse
    {
        abort_unless($submission->assignment->teacher_id === auth()->id(), 403);
        request()->validate(['score' => ['nullable', 'integer', 'min:0', 'max:'.$submission->assignment->max_points], 'feedback' => ['nullable', 'string', 'max:2000']]);
        $score = request('score');

        if ($submission->status === 'late') {
            $score = null;
        }

        $submission->update(['status' => $score === null ? 'not_graded' : 'graded']);
        $submission->assignment->grades()->updateOrCreate(['student_id' => $submission->student_id], ['score' => $score, 'feedback' => request('feedback'), 'status' => $score === null ? 'not_graded' : 'graded']);

        return back()->with('success', 'Nilai siswa berhasil diperbarui.');
    }
}
