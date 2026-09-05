<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Grade;
use App\Models\LearningMaterial;
use App\Models\Schedule;
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
        User::factory()->create([
            'name' => 'Aditya Ramadhan',
            'email' => 'test@example.com',
        ]);

        Assignment::create(['title' => 'Eksplorasi Fungsi Kuadrat', 'subject' => 'Matematika', 'teacher' => 'Bu Rina Kartika', 'description' => 'Buat rangkuman konsep fungsi kuadrat dan selesaikan lima soal aplikasi.', 'due_at' => now()->addDay()->setTime(23, 59), 'max_points' => 100]);
        Assignment::create(['title' => 'Normalisasi Basis Data', 'subject' => 'Basis Data', 'teacher' => 'Pak Dadan Sutisna', 'description' => 'Analisis tabel transaksi menjadi bentuk normal ketiga beserta relasinya.', 'due_at' => now()->addDays(7)->setTime(23, 59), 'max_points' => 80]);
        Assignment::create(['title' => 'Menulis Teks Eksposisi', 'subject' => 'Bahasa Indonesia', 'teacher' => 'Bu Sari Puspita', 'description' => 'Tulis teks eksposisi bertema teknologi hijau.', 'due_at' => now()->subDay()->setTime(16, 0), 'max_points' => 100, 'status' => 'submitted', 'submitted_at' => now()->subDays(2)]);
        Assignment::create(['title' => 'Mini Project: Landing Page', 'subject' => 'Pemrograman Web', 'teacher' => 'Pak Asep Nugraha', 'description' => 'Kembangkan landing page responsif menggunakan HTML dan CSS.', 'due_at' => now()->addDays(13)->setTime(23, 59), 'max_points' => 120]);

        foreach ([
            ['subject' => 'Pemrograman Web', 'teacher' => 'Pak Asep Nugraha', 'room' => 'R. Lab Komputer 2', 'starts_at' => '07:00', 'ends_at' => '08:30'],
            ['subject' => 'Matematika', 'teacher' => 'Bu Rina Kartika', 'room' => 'R. 204', 'starts_at' => '08:45', 'ends_at' => '10:15'],
            ['subject' => 'Bahasa Inggris', 'teacher' => 'Mr. David', 'room' => 'R. 204', 'starts_at' => '10:30', 'ends_at' => '12:00'],
        ] as $schedule) {
            Schedule::create($schedule + ['day_of_week' => 'Senin', 'schedule_date' => now()->addDays(2)->toDateString()]);
        }

        foreach ([
            ['subject' => 'Matematika', 'teacher' => 'Bu Rina Kartika', 'score' => 91, 'notes' => 'Sangat baik'],
            ['subject' => 'Basis Data', 'teacher' => 'Pak Dadan Sutisna', 'score' => 86, 'notes' => 'Baik'],
            ['subject' => 'Bahasa Indonesia', 'teacher' => 'Bu Sari Puspita', 'score' => 89, 'notes' => 'Sangat baik'],
            ['subject' => 'Pemrograman Web', 'teacher' => 'Pak Asep Nugraha', 'score' => 88, 'notes' => 'Baik'],
        ] as $grade) {
            Grade::create($grade + ['semester' => 'Semester Ganjil 2026/2027']);
        }

        LearningMaterial::create(['title' => 'Pengenalan HTML Semantik', 'subject' => 'Pemrograman Web', 'teacher' => 'Pak Asep Nugraha', 'description' => 'Mengenal struktur HTML yang bermakna dan mudah dirawat.', 'published_at' => now()->subDay()]);
        LearningMaterial::create(['title' => 'Fungsi Kuadrat dan Grafik', 'subject' => 'Matematika', 'teacher' => 'Bu Rina Kartika', 'description' => 'Modul ringkas untuk memahami bentuk dan karakteristik grafik.', 'published_at' => now()->subDays(3)]);
        LearningMaterial::create(['title' => 'Teknik Menulis Eksposisi', 'subject' => 'Bahasa Indonesia', 'teacher' => 'Bu Sari Puspita', 'description' => 'Panduan menyusun tesis, argumentasi, dan penegasan ulang.', 'published_at' => now()->subDays(5)]);
    }
}
