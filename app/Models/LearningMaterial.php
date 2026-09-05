<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'subject', 'teacher', 'description', 'file_path', 'published_at'])]
class LearningMaterial extends Model
{
    protected function casts(): array
    {
        return ['published_at' => 'datetime'];
    }
}
