<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'loans')
            ->withPivot('loan_date', 'due_date', 'return_date')
            ->withTimestamps();
    }

    public function activeLoans()
    {
        return $this->hasMany(Loan::class)->whereNull('return_date');
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return \Carbon\Carbon::parse($date)
            ->timezone('Asia/Jakarta')
            ->format('d-m-y H:i');
    }
}
