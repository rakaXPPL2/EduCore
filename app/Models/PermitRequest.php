<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['student_name', 'type', 'permit_date', 'description', 'attachment_path', 'status'])]
class PermitRequest extends Model
{
    protected function casts(): array
    {
        return ['permit_date' => 'date'];
    }
}
