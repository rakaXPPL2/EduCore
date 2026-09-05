<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['pkl_application_id', 'user_id', 'report_path', 'status', 'feedback', 'reviewed_by', 'reviewed_at'])]
class PklReport extends Model
{
    protected function casts(): array
    {
        return ['reviewed_at' => 'datetime'];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(PklApplication::class, 'pkl_application_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function defense(): HasOne
    {
        return $this->hasOne(PklDefense::class);
    }
}
