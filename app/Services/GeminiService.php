<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    public function analyzePklJob(string $caption): array
    {
        return $this->generateContent([
            [
                'text' => implode("\n", [
                    'Analisis caption lowongan PKL berikut dan kembalikan JSON valid dengan struktur:',
                    '{"ringkasan": string, "bidang": string, "rekomendasi_jurusan": [string], "skills": [string], "tingkat_kesesuaian": number}',
                    'Caption:',
                    $caption,
                ]),
            ],
        ]);
    }

    public function verifyPermitLetter(string $imagePath, string $studentName, string $permitDate): array
    {
        if (! is_file($imagePath)) {
            return $this->failure('Berkas surat izin tidak ditemukan.');
        }

        $imageContents = file_get_contents($imagePath);
        $mimeType = mime_content_type($imagePath);

        if ($imageContents === false || $mimeType === false || ! str_starts_with($mimeType, 'image/')) {
            return $this->failure('Berkas surat izin harus berupa gambar yang dapat dibaca.');
        }

        return $this->generateContent([
            [
                'text' => implode("\n", [
                    'Verifikasi surat izin PKL pada gambar ini dan kembalikan JSON valid dengan struktur:',
                    '{"valid": boolean, "nama_di_surat": string|null, "tanggal_di_surat": string|null, "nama_cocok": boolean, "tanggal_cocok": boolean, "alasan": string}',
                    'Nama siswa yang diharapkan: '.$studentName,
                    'Tanggal izin yang diharapkan: '.$permitDate,
                    'Lakukan OCR, lalu kroscek nama dan tanggal terhadap nilai yang diberikan.',
                ]),
            ],
            [
                'inline_data' => [
                    'mime_type' => $mimeType,
                    'data' => base64_encode($imageContents),
                ],
            ],
        ]);
    }

    /**
     * @param  array<string, mixed>  $context
     * @return array{success: bool, data?: array<string, mixed>, error?: string}
     */
    public function studentCoach(string $message, array $context): array
    {
        return $this->generateContent([
            [
                'text' => implode("\n", [
                    'Kamu adalah EduCoach, pendamping belajar yang hangat untuk siswa SMK.',
                    'Jawab pertanyaan siswa dalam Bahasa Indonesia dengan akurat, singkat, konkret, dan tidak menghakimi.',
                    'Gunakan data progres siswa sebagai sumber utama. Jangan mengarang nilai, tugas, jadwal, aturan sekolah, atau fakta yang tidak ada di konteks.',
                    'Jika pertanyaan membutuhkan data yang tidak tersedia atau kepastian profesional, katakan keterbatasannya dan sarankan sumber yang tepat.',
                    'Untuk pertanyaan umum, berikan penjelasan berdasarkan pengetahuan yang kamu miliki dan tandai jika informasinya dapat berubah.',
                    'Jangan menjanjikan penerimaan kuliah, memberi diagnosis medis/psikologis, atau mengambil keputusan atas nama sekolah.',
                    'Kembalikan JSON valid dengan struktur:',
                    '{"reply": string, "insights": [{"label": string, "value": string}]}',
                    'Data siswa:',
                    json_encode($context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                    'Pertanyaan siswa:',
                    $message,
                ]),
            ],
        ]);
    }

    /**
     * @param  array<int, array<string, mixed>>  $parts
     * @return array{success: bool, data?: array<string, mixed>, error?: string}
     */
    private function generateContent(array $parts): array
    {
        $apiKey = config('services.gemini.key');

        if (! is_string($apiKey) || $apiKey === '') {
            return $this->failure('GEMINI_API_KEY belum dikonfigurasi.');
        }

        try {
            $caBundle = config('services.gemini.ca_bundle');
            $http = Http::connectTimeout(5)->withHeaders([
                'Content-Type' => 'application/json',
                'x-goog-api-key' => $apiKey,
            ])->withOptions([
                'verify' => is_string($caBundle) && is_file($caBundle) ? $caBundle : true,
            ])->timeout(30)->retry([250, 500], 0, function (\Throwable $exception): bool {
                return $exception instanceof ConnectionException
                    || ($exception instanceof RequestException
                        && ($exception->response->serverError() || $exception->response->status() === 429));
            }, throw: false);

            $response = $http->post(
                (string) config('services.gemini.endpoint'),
                [
                    'contents' => [['parts' => $parts]],
                    'generationConfig' => [
                        'responseMimeType' => 'application/json',
                    ],
                ],
            );

            $response->throw();
            $text = $response->json('candidates.0.content.parts.0.text');
            $data = is_string($text) ? json_decode(trim($text), true) : null;

            if (! is_array($data) || json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Gemini returned invalid JSON.', ['response' => $response->json()]);

                return $this->failure('Respons Gemini bukan JSON yang valid.');
            }

            return ['success' => true, 'data' => $data];
        } catch (RequestException|ConnectionException $exception) {
            Log::error('Gemini API request failed.', [
                'message' => $exception->getMessage(),
                'status' => $exception instanceof RequestException ? $exception->response->status() : null,
            ]);

            return $this->failure('Gagal menghubungi Gemini API.');
        }
    }

    /**
     * @return array{success: false, error: string}
     */
    private function failure(string $message): array
    {
        Log::error('Gemini integration failed.', ['error' => $message]);

        return ['success' => false, 'error' => $message];
    }
}
