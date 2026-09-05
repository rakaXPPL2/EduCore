<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['subject', 'teacher', 'room', 'day_of_week', 'schedule_date', 'starts_at', 'ends_at'])]
class Schedule extends Model
{
    protected function casts(): array
    {
        return ['schedule_date' => 'date'];
    }
}
