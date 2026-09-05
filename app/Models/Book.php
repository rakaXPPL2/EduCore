<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['book_code', 'isbn', 'title', 'author', 'publisher', 'publish_year', 'edition', 'language', 'page_count', 'book_format', 'reading_level', 'ddc_code', 'rack_location', 'total_stock', 'available_stock', 'category_id', 'synopsis', 'keywords', 'cover_image'])]
class Book extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'publish_year' => 'integer',
            'page_count' => 'integer',
            'total_stock' => 'integer',
            'available_stock' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}
