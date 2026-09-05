<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'subject', 'teacher', 'description', 'due_at', 'max_points', 'status', 'submitted_at', 'submission_path'])]
class Assignment extends Model
{
    protected function casts(): array
    {
        return [
            'due_at' => 'datetime',
            'submitted_at' => 'datetime',
            'max_points' => 'integer',
        ];
    }
}
