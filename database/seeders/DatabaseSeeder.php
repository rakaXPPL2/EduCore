<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Grade;
use App\Models\LearningMaterial;
use App\Models\LokerPkl;
use App\Models\PklSetting;
use App\Models\Schedule;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(['email' => 'test@example.com'], [
            'name' => 'Aditya Ramadhan',
            'role' => 'student',
            'student_class' => 'XI RPL 2',
            'password' => 'password',
        ]);

        User::updateOrCreate(['email' => 'guru@educore.test'], [
            'name' => 'Dadan Sutisna',
            'role' => 'teacher',
            'teacher_subject' => 'Basis Data',
            'password' => 'password',
        ]);

        User::updateOrCreate(['email' => 'admin@educore.test'], [
            'name' => 'Admin EduCore',
            'role' => 'admin',
            'password' => 'password',
        ]);

        User::updateOrCreate(['email' => 'murid@educore.test'], [
            'name' => 'Aditya Ramadhan',
            'role' => 'student',
            'student_class' => 'XI RPL 2',
            'password' => 'password',
        ]);

        $teacher = User::query()->where('email', 'guru@educore.test')->firstOrFail();
        $schoolClass = SchoolClass::firstOrCreate(
            ['name' => 'XI RPL 2'],
            ['level' => 'XI', 'homeroom_teacher_id' => $teacher->id],
        );
        User::query()->where('role', 'student')->update(['school_class_id' => $schoolClass->id]);
        PklSetting::updateOrCreate(['id' => 1], ['school_level' => 'smk', 'pkl_enabled' => true, 'period' => '2026/2027', 'defense_start_date' => now()->addMonths(2)->toDateString()]);
        LokerPkl::create(['company_name' => 'PT Digital Garut', 'location' => 'Garut', 'school_level' => 'smk', 'caption' => 'Pengembangan web dan dukungan teknologi.', 'description' => 'Mendampingi tim dalam pengembangan website, dokumentasi, dan pengujian aplikasi.', 'quota' => 5, 'application_deadline' => now()->addMonth()->toDateString(), 'status' => 'published']);
        LokerPkl::create(['company_name' => 'Studio Kreatif Priangan', 'location' => 'Tarogong', 'school_level' => 'smk', 'caption' => 'Desain konten dan media digital.', 'description' => 'Membantu produksi konten visual, editing video, dan pengelolaan media sosial.', 'quota' => 3, 'application_deadline' => now()->addMonth()->toDateString(), 'status' => 'published']);
        User::factory(38)->create(['role' => 'student', 'student_class' => 'XI RPL 2', 'school_class_id' => $schoolClass->id, 'password' => 'password']);
        $subjects = collect([
            ['name' => 'Matematika', 'code' => 'MTK'],
            ['name' => 'Basis Data', 'code' => 'BD'],
            ['name' => 'Bahasa Indonesia', 'code' => 'BIN'],
            ['name' => 'Pemrograman Web', 'code' => 'PWEB'],
        ])->mapWithKeys(fn (array $subject): array => [$subject['name'] => Subject::firstOrCreate(['name' => $subject['name']], ['code' => $subject['code']])]);

        Assignment::create(['title' => 'Eksplorasi Fungsi Kuadrat', 'subject' => 'Matematika', 'subject_id' => $subjects['Matematika']->id, 'school_class_id' => $schoolClass->id, 'teacher_id' => $teacher->id, 'teacher' => $teacher->name, 'description' => 'Buat rangkuman konsep fungsi kuadrat dan selesaikan lima soal aplikasi.', 'due_at' => now()->addDay()->setTime(23, 59), 'max_points' => 100]);
        Assignment::create(['title' => 'Normalisasi Basis Data', 'subject' => 'Basis Data', 'subject_id' => $subjects['Basis Data']->id, 'school_class_id' => $schoolClass->id, 'teacher_id' => $teacher->id, 'teacher' => $teacher->name, 'description' => 'Analisis tabel transaksi menjadi bentuk normal ketiga beserta relasinya.', 'due_at' => now()->addDays(7)->setTime(23, 59), 'max_points' => 80]);
        Assignment::create(['title' => 'Menulis Teks Eksposisi', 'subject' => 'Bahasa Indonesia', 'subject_id' => $subjects['Bahasa Indonesia']->id, 'school_class_id' => $schoolClass->id, 'teacher_id' => $teacher->id, 'teacher' => $teacher->name, 'description' => 'Tulis teks eksposisi bertema teknologi hijau.', 'due_at' => now()->subDay()->setTime(16, 0), 'max_points' => 100, 'status' => 'submitted', 'submitted_at' => now()->subDays(2)]);
        Assignment::create(['title' => 'Mini Project: Landing Page', 'subject' => 'Pemrograman Web', 'subject_id' => $subjects['Pemrograman Web']->id, 'school_class_id' => $schoolClass->id, 'teacher_id' => $teacher->id, 'teacher' => $teacher->name, 'description' => 'Kembangkan landing page responsif menggunakan HTML dan CSS.', 'due_at' => now()->addDays(13)->setTime(23, 59), 'max_points' => 120]);

        foreach ([
            ['subject' => 'Pemrograman Web', 'teacher' => 'Pak Asep Nugraha', 'room' => 'R. Lab Komputer 2', 'starts_at' => '07:00', 'ends_at' => '08:30'],
            ['subject' => 'Matematika', 'teacher' => 'Bu Rina Kartika', 'room' => 'R. 204', 'starts_at' => '08:45', 'ends_at' => '10:15'],
            ['subject' => 'Bahasa Inggris', 'teacher' => 'Mr. David', 'room' => 'R. 204', 'starts_at' => '10:30', 'ends_at' => '12:00'],
        ] as $schedule) {
            Schedule::create($schedule + ['school_class_id' => $schoolClass->id, 'day_of_week' => 'Senin', 'schedule_date' => now()->addDays(2)->toDateString()]);
        }

        foreach ([
            ['subject' => 'Matematika', 'teacher' => 'Bu Rina Kartika', 'score' => 91, 'notes' => 'Sangat baik'],
            ['subject' => 'Basis Data', 'teacher' => 'Pak Dadan Sutisna', 'score' => 86, 'notes' => 'Baik'],
            ['subject' => 'Bahasa Indonesia', 'teacher' => 'Bu Sari Puspita', 'score' => 89, 'notes' => 'Sangat baik'],
            ['subject' => 'Pemrograman Web', 'teacher' => 'Pak Asep Nugraha', 'score' => 88, 'notes' => 'Baik'],
        ] as $grade) {
            Grade::create($grade + ['semester' => 'Semester Ganjil 2026/2027']);
        }

        LearningMaterial::create(['title' => 'Pengenalan HTML Semantik', 'subject' => 'Pemrograman Web', 'teacher' => 'Pak Asep Nugraha', 'description' => 'Mengenal struktur HTML yang bermakna dan mudah dirawat.', 'school_class_id' => $schoolClass->id, 'published_at' => now()->subDay()]);
        LearningMaterial::create(['title' => 'Fungsi Kuadrat dan Grafik', 'subject' => 'Matematika', 'teacher' => 'Bu Rina Kartika', 'description' => 'Modul ringkas untuk memahami bentuk dan karakteristik grafik.', 'school_class_id' => $schoolClass->id, 'published_at' => now()->subDays(3)]);
        LearningMaterial::create(['title' => 'Teknik Menulis Eksposisi', 'subject' => 'Bahasa Indonesia', 'teacher' => 'Bu Sari Puspita', 'description' => 'Panduan menyusun tesis, argumentasi, dan penegasan ulang.', 'school_class_id' => $schoolClass->id, 'published_at' => now()->subDays(5)]);
    }
}
