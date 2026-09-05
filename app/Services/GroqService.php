<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqService
{
    /**
     * @param  array<string, mixed>  $studentContext
     * @return array{success: bool, reply?: string, error?: string}
     */
    public function askTutor(string $userPrompt, array $studentContext = []): array
    {
        $apiKey = config('services.groq.key');

        if (! is_string($apiKey) || $apiKey === '') {
            return ['success' => false, 'error' => 'GROQ_API_KEY belum dikonfigurasi.'];
        }

        $systemPrompt = implode("\n", [
            'Kamu adalah EduCoach, AI Tutor untuk siswa SMKN 1 Garut.',
            'Jawab persis sesuai pertanyaan pengguna dalam Bahasa Indonesia yang jelas, hangat, dan konkret.',
            'Gunakan konteks siswa hanya jika relevan dengan pertanyaan.',
            'Jangan mengarang data siswa. Jika informasi tidak tersedia, katakan dengan jujur.',
            'Untuk pertanyaan umum, jawab pertanyaan tersebut langsung dan jangan mengalihkan pembahasan ke tugas atau nilai.',
            'Jangan memberikan diagnosis medis/psikologis atau keputusan resmi sekolah.',
            'Konteks siswa:',
            json_encode($studentContext, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        ]);

        try {
            $caBundle = config('services.groq.ca_bundle');
            $response = Http::connectTimeout(5)
                ->withToken($apiKey)
                ->acceptJson()
                ->withOptions([
                    'verify' => is_string($caBundle) && is_file($caBundle) ? $caBundle : true,
                ])
                ->timeout(30)
                ->retry([250, 500], 0, function (\Throwable $exception): bool {
                    return $exception instanceof ConnectionException
                        || ($exception instanceof RequestException
                            && ($exception->response->serverError() || $exception->response->status() === 429));
                }, throw: false)
                ->post((string) config('services.groq.url'), [
                    'model' => config('services.groq.model'),
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userPrompt],
                    ],
                    'temperature' => 0.4,
                    'max_tokens' => 600,
                ]);

            $response->throw();
            $reply = $response->json('choices.0.message.content');

            if (! is_string($reply) || trim($reply) === '') {
                Log::error('Groq returned an empty response.', ['response' => $response->json()]);

                return ['success' => false, 'error' => 'Respons Groq kosong.'];
            }

            return ['success' => true, 'reply' => trim($reply)];
        } catch (RequestException|ConnectionException $exception) {
            Log::error('Groq API request failed.', [
                'message' => $exception->getMessage(),
                'status' => $exception instanceof RequestException ? $exception->response->status() : null,
            ]);

            return ['success' => false, 'error' => 'Gagal menghubungi Groq API.'];
        }
    }
}
