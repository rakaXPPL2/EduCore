<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['subject', 'teacher', 'score', 'semester', 'notes'])]
class Grade extends Model
{
    protected function casts(): array
    {
        return ['score' => 'decimal:2'];
    }
}
