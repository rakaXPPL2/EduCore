<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['user_id', 'loker_pkl_id', 'motivation', 'status', 'admin_note'])]
class PklApplication extends Model
{
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lokerPkl(): BelongsTo
    {
        return $this->belongsTo(LokerPkl::class);
    }

    public function report(): HasOne
    {
        return $this->hasOne(PklReport::class);
    }
}
