<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\GeminiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicSchoolChatController extends Controller
{
    public function __invoke(Request $request, GeminiService $gemini): JsonResponse
    {
        $message = (string) $request->validate(['message' => ['required', 'string', 'max:500']])['message'];
        $result = $gemini->studentCoach($message, [
            'school' => 'SMKN 1 Garut, sekolah menengah kejuruan negeri di Kabupaten Garut, Jawa Barat',
            'programs' => ['PPLG', 'DKV', 'TJKT', 'AKL', 'MPLB', 'PM', 'TKF', 'TLG', 'TET', 'TLM'],
            'facts' => ['berdiri 1951', 'akreditasi A', 'alamat Jl. Cimanuk No. 309A, Garut', 'pendaftaran melalui portal PPDB Jawa Barat'],
            'audience' => 'calon siswa, orang tua, dan pengunjung website',
        ]);

        if ($result['success']) {
            return response()->json(['success' => true, 'reply' => $result['data']['reply'] ?? 'Aku siap membantu menjawab pertanyaan tentang SMKN 1 Garut.']);
        }

        $lowerMessage = Str::lower($message);
        $reply = 'Aku bisa membantu tentang jurusan, fasilitas, kegiatan belajar, alamat, dan PPDB SMKN 1 Garut. Coba tanyakan salah satunya.';

        if (Str::contains($lowerMessage, ['jurusan', 'program', 'keahlian'])) {
            $reply = 'SMKN 1 Garut memiliki 10 kompetensi keahlian: PPLG, DKV, TJKT, AKL, MPLB, PM, TKF, TLG, TET, dan TLM. Pilih berdasarkan minat, cara belajar, serta bidang yang ingin kamu eksplorasi.';
        } elseif (Str::contains($lowerMessage, ['ppdb', 'daftar', 'syarat', 'pendaftaran'])) {
            $reply = 'Untuk PPDB, siapkan ijazah atau SKL, KK, akta kelahiran, rapor semester 1-5, dan pas foto. Jadwal resmi mengikuti PPDB Provinsi Jawa Barat melalui portal ppdb.jabarprov.go.id.';
        } elseif (Str::contains($lowerMessage, ['alamat', 'lokasi', 'di mana'])) {
            $reply = 'SMKN 1 Garut berada di Jl. Cimanuk No. 309A, Sukagalih, Tarogong Kidul, Kabupaten Garut, Jawa Barat 44151.';
        } elseif (Str::contains($lowerMessage, ['siapa', 'sekolah ini', 'tentang'])) {
            $reply = 'SMKN 1 Garut adalah SMK negeri yang berdiri sejak 1951 dengan akreditasi A. Kami menyiapkan siswa melalui kompetensi vokasi, karakter, dan pengalaman yang terhubung dengan industri.';
        }

        return response()->json(['success' => true, 'reply' => $reply, 'fallback' => true]);
    }
}
