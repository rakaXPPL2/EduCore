<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\GeminiService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('test:gemini')]
#[Description('Verifikasi koneksi dan output JSON Gemini.')]
class TestGemini extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $result = app(GeminiService::class)->analyzePklJob(
            'Siswa PKL membantu pengembangan aplikasi web menggunakan PHP dan MySQL.',
        );

        if (! $result['success']) {
            $this->error($result['error']);

            return self::FAILURE;
        }

        $this->line(json_encode($result['data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return self::SUCCESS;
    }
}
