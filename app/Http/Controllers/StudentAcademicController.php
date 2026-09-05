<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChatMessageRequest;
use App\Http\Requests\StoreSubmissionRequest;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\ChatMessage;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StudentAcademicController extends Controller
{
    public function assignments(): View
    {
        $student = auth()->user();
        $assignments = Assignment::query()->where('school_class_id', $student->school_class_id)->with(['subjectModel', 'teacherUser', 'submissions' => fn ($query) => $query->where('student_id', $student->id)])->orderBy('due_at')->get();

        return view('student-assignments', compact('assignments'));
    }

    public function submit(StoreSubmissionRequest $request, Assignment $assignment): RedirectResponse
    {
        abort_unless($assignment->school_class_id === auth()->user()->school_class_id, 403);
        $data = $request->validated();
        $submission = AssignmentSubmission::updateOrCreate(['assignment_id' => $assignment->id, 'student_id' => auth()->id()], [
            'file_path' => $request->file('file')?->store('submissions', 'public'),
            'photo_path' => $request->file('photo')?->store('submission-photos', 'public'),
            'link' => $data['link'] ?? null,
            'submitted_at' => now(),
            'status' => now()->greaterThan($assignment->due_at) ? 'late' : 'submitted',
        ]);

        return back()->with('success', $submission->status === 'late' ? 'Tugas dikirim terlambat dan menunggu kebijakan guru.' : 'Tugas berhasil dikirim.');
    }

    public function chat(): View
    {
        $student = auth()->user();
        $subjects = Subject::query()->whereHas('assignments', fn ($query) => $query->where('school_class_id', $student->school_class_id))->orderBy('name')->get();
        $messages = ChatMessage::query()->where('school_class_id', $student->school_class_id)->with(['sender', 'subject'])->latest()->limit(50)->get()->reverse();

        return view('student-chat', compact('subjects', 'messages'));
    }

    public function sendChat(StoreChatMessageRequest $request): RedirectResponse
    {
        abort_unless(auth()->user()->school_class_id === (int) $request->validated('school_class_id'), 403);
        $teacherId = Assignment::query()->where('school_class_id', $request->validated('school_class_id'))->where('subject_id', $request->validated('subject_id'))->whereNotNull('teacher_id')->value('teacher_id');
        ChatMessage::create(['school_class_id' => $request->validated('school_class_id'), 'subject_id' => $request->validated('subject_id'), 'sender_id' => auth()->id(), 'recipient_id' => $teacherId, 'body' => $request->validated('body')]);

        return back()->with('success', 'Pesan berhasil dikirim ke guru mapel.');
    }
}
