<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'code'])]
class Subject extends Model
{
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class, 'subject_id');
    }
}
