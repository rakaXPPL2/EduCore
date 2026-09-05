<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'level', 'homeroom_teacher_id'])]
class SchoolClass extends Model
{
    public function homeroomTeacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'homeroom_teacher_id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(User::class, 'school_class_id')->where('role', 'student');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }
}
