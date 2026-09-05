<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['pkl_report_id', 'user_id', 'scheduled_at', 'room', 'examiner', 'status', 'notes'])]
class PklDefense extends Model
{
    protected function casts(): array
    {
        return ['scheduled_at' => 'datetime'];
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(PklReport::class, 'pkl_report_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
