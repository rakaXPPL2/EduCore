<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['school_level', 'pkl_enabled', 'period', 'defense_start_date'])]
class PklSetting extends Model
{
    protected function casts(): array
    {
        return [
            'pkl_enabled' => 'boolean',
            'defense_start_date' => 'date',
        ];
    }
}
