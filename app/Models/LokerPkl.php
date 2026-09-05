<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['company_name', 'location', 'address', 'school_level', 'major', 'class_level', 'class_number', 'caption', 'description', 'poster_path', 'quota', 'application_deadline', 'status', 'hasil_analisis', 'rekomendasi_jurusan', 'suggested_by', 'suggestion_status', 'is_featured'])]
class LokerPkl extends Model
{
    public function applications(): HasMany
    {
        return $this->hasMany(PklApplication::class);
    }

    public function suggestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'suggested_by');
    }

    protected function casts(): array
    {
        return [
            'hasil_analisis' => 'array',
            'rekomendasi_jurusan' => 'array',
            'application_deadline' => 'date',
            'is_featured' => 'boolean',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where(function ($q) {
                $q->where('suggestion_status', 'direct')
                    ->orWhere('suggestion_status', 'approved');
            });
    }

    public function scopeSuggested($query)
    {
        return $query->where('suggestion_status', 'suggested');
    }
}
