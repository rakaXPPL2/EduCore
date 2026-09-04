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
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-goog-api-key' => $apiKey,
            ])->timeout(30)->retry(3, 250, throw: false)->post(
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
            $data = is_string($text) ? json_decode($text, true) : null;

            if (! is_array($data)) {
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
