<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'published_year',
        'isbn',
        'stock'
    ];

    protected $casts = [
        'published_year' => 'integer',
        'stock' => 'integer'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'loans')
            ->withPivot('loan_date', 'due_date', 'return_date')
            ->withTimestamps();
    }

    public function activeLoans()
    {
        return $this->hasMany(Loan::class)->whereNull('return_date');
    }

    public function getAvailableStockAttribute(): int
    {
        return $this->stock - $this->activeLoans()->count();
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return Carbon::parse($date)
            ->timezone('Asia/Jakarta')
            ->format('d-m-y H:i');
    }
}
